<?php

namespace Rma\Cache;

use Exception;
use Rma\Options\RmaOptions;

/**
 * I think we should break these into three services: Cache, Cache Local and CacheMemory
 *
 * @package Rma\Cache
 */
class Cache {
	private static $instance;

	private string $cachepath = 'data/';
	private string $_cachename = 'rma-tools';
	private string $_extension = '.json';

	//In memory version of the cache to prevent multiple file opens
	private $cache;

	public ?bool $hasPermission = null;

	private array $debug = [
		'instantiations' => 0,
		'requests'       => 0,
		'misses'         => 0,
	];

	public static function get_instance(): Cache {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}

		self::$instance->increment_instantiations();

		return self::$instance;
	}

	public function __construct() {
	}

	public function store( $key, $data, $expiration = null ): void {
		$options = RmaOptions::get_options();
		$expire  = $expiration === null ? $options->cache_duration : $expiration;

		if ( $expiration === 0 ) {
			return;
		}

		$storeData = array(
			'time'   => time(),
			'expire' => $expire,
			'data'   => serialize( $data )
		);

		$dataArray = $this->load_cache();

		if ( is_array( $dataArray ) ) {
			$dataArray[ $key ] = $storeData;
		} else {
			$dataArray = [ $key => $storeData ];
		}

		$this->save_cache( $dataArray );
	}

	public function retrieve( $key ) {
		$cachedData = $this->load_cache();
		$type       = 'data';

		$this->increment_requests();

		if ( ! isset( $cachedData[ $key ] ) ) {
			return null;
		}

		$hit = $cachedData[ $key ];

		if ( ! $this->check_expiry( $hit['time'], $hit['expire'] ) || ! isset( $hit[ $type ] ) ) {
			$this->increment_misses();

			return null;
		}

		return unserialize( $hit[ $type ] );
	}

	public function retrieve_or_fail( $key ) {
		$hit = $this->retrieve( $key );

		if ( $hit ) {
			return $hit;
		}

		throw new Exception( $key );
	}

	public function retrieve_all( $meta = false ) {
		$cachedData = $this->load_cache();
		if ( $meta === true ) {
			return $cachedData;
		}
		$results = [];
		if ( $cachedData ) {
			foreach ( $cachedData as $k => $v ) {
				$results[ $k ] = unserialize( $v['data'] );
			}
		}

		return $results;
	}

	public function delete( $key ) {
		$cacheData = $this->load_cache();
		if ( is_array( $cacheData ) ) {
			if ( isset( $cacheData[ $key ] ) ) {
				unset( $cacheData[ $key ] );
				$this->save_cache( $cacheData );
			} else {
				throw new Exception( "Error: erase() - Key '{$key}' not found." );
			}
		}

		return $this;
	}

	public function delete_expired() {
		$cacheData = $this->load_cache();
		if ( is_array( $cacheData ) ) {
			$counter = 0;
			foreach ( $cacheData as $key => $entry ) {
				if ( $this->check_expiry( $entry['time'], $entry['expire'] ) ) {
					unset( $cacheData[ $key ] );
					$counter ++;
				}
			}
			if ( $counter > 0 ) {
				$this->save_cache( $cacheData );
			}

			return $counter;
		}
	}


	public function clear() {
		$cacheDir = $this->get_cache_folder();
		if ( file_exists( $cacheDir ) ) {
			$cacheFile = fopen( $cacheDir, 'w' );
			fclose( $cacheFile );
			$this->cache = null;
		}
	}

	public function get_debug_information() {
		return $this->debug;
	}


	public function get_cache_path() {
		return dirname( __FILE__ ) . '/' . $this->cachepath;
	}

	public function increment_instantiations() {
		$this->increment_debug( 'instantiations' );
	}

	public function generate_key( $fragments ) {

		return implode( ':', $fragments );
	}

	private function load_cache() {
		if ( $this->cache ) {
			return $this->cache;
		}
		$cacheDir = $this->get_cache_folder();

		if ( file_exists( $cacheDir ) ) {
			$file        = file_get_contents( $cacheDir );
			$this->cache = json_decode( $file, true );

			return $this->cache;
		}

		return false;
	}

	private function save_cache( $dataArray ) {
		if ( $this->check_folder_permissions() ) {
			$this->cache = $dataArray;
			$cacheData   = json_encode( $dataArray );
			file_put_contents( $this->get_cache_folder(), $cacheData );
		}
	}

	private function get_cache_folder() {
		if ( $this->check_folder_permissions() ) {
			$filename = $this->_cachename;
			$filename = preg_replace( '/[^0-9a-z\.\_\-]/i', '', strtolower( $filename ) );

			return $this->get_cache_path() . sha1( $filename ) . $this->_extension;
		}
	}

	private function check_expiry( $timestamp, $expiration ) {
		if ( $expiration === 0 ) {
			return false;
		}

		$timeDiff = time() - $timestamp;

		return ! ( $timeDiff > $expiration );
	}

	public function check_folder_permissions() {
		if ( $this->hasPermission !== null ) {
			return $this->hasPermission;
		}
		$cacheDir = $this->get_cache_path();
		try {

			if ( ! is_writable( dirname( __FILE__ ) ) ) {
				throw new Exception( 'Parent directory is not writable: ' . $cacheDir );
			}

			if ( ! is_dir( $cacheDir ) ) {
				mkdir( $cacheDir, 0775, true );
			}

			if ( ! is_writable( $cacheDir ) ) {
				throw new Exception( 'Cache directory is not writable: ' . $cacheDir );
			}

			if ( ! is_readable( $cacheDir ) ) {
				if ( ! chmod( $cacheDir, 0775 ) ) {
					throw new Exception( 'Cache directory is not readable: ' . $cacheDir );
				}
			}
			$this->hasPermission = true;
		} catch ( Exception $e ) {
			$this->hasPermission = false;
		}


		return $this->hasPermission;
	}

	private function increment_requests() {
		$this->increment_debug( 'requests' );
	}

	private function increment_misses() {
		$this->increment_debug( 'misses' );
	}

	private function increment_debug( $key ) {
		$debug         = $this->debug;
		$debug[ $key ] = $debug[ $key ] + 1;
		$this->debug   = $debug;
	}
}
