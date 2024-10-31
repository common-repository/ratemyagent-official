=== RateMyAgent Official ===
Contributors: tbstones
Tags: reviews, real estate
Requires at least: 5.8
Tested up to: 6.6.1
Requires PHP: 8.0
Stable tag: 1.4.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The official plugin for displaying RateMyAgent content on your site.

== Description ==
RateMyAgent Official Plugin allows you to display your 4 & 5-star reviews on your website as well as your property listing and sale data.

**Current Features**:
* Multiple review layouts to choose from
* Listing carousel
* Sold Property carousel
* Theme colour customization
* Step by step wizard to set up

== Installation ==
1. Upload zip archive to the "/wp-content/plugins/" directory.
1. Activate the plugin through the "Plugins" menu in WordPress (`/admin.php?page=rma-settings`).
1. Use the block editor to add `Review Carousel` or 'Listing Carousel'

== Using shortcodes ==

Under the hood, the blocks are just a wrapper on short codes which allows people who use other page builders ( [elementor](https://elementor.com/), [Beaver Builder](https://www.wpbeaverbuilder.com/), etc) and template developers to add them too.

= Review Carousel =

`[rma-review-carousel template_type="full" is_leasing="true" profile_type="agency" profile_code="aaXXXX" ] [/rma-review-carousel]`

**Options**:

*is_leasing*:

*  `true`
*  `false` (default)


*profile_type*:

* `agent` (default)
* `agency`
* `mortgage-broker`

*profile_code*:

* the profile code of the agent/agency

*template_type* :

* `full` (default)
* `no-property`
* `review-only`
* `full-review`

*heading*:

* string (optional) (note: you can use `{reviewCount}`  in the heading to print the profile's total review count. like "350 Happy customers")

 = Listing Carousel =

`[rma-listings-carousel profile_code="aaXXXX" profile_type="agent" template_type="full" ][/rma-listings-carousel]`

*profile_type*:

*  `agent` (default)
*  `agency`

*profile_code*:

* the profile code of the agent/agency

*template_type*:

* `full` (default)

> Note:  If you are using the  default value for any option, you do not need to supply it

== Frequently Asked Questions ==

= Does this plugin require a RateMyAgent Subscription =
Yes

== Changelog ==

= 1.4.0 =
* Updated support to 6.6.1
* PHP 8.0
* New Review Carousel layout

= 1.3.1 =
* Updated support to 6.4.2

= 1.2.1 =
* Added `no avatar` template for reviews

= 1.2.0 =
* Fixed issue when removing block
* Fixed full review was not centre aligned
* Added add `classnames` from block to wrapping div
* Added feedback around profile code being lowercase
* Added better feedback messages around
* Added support for lazy loaded javascript


= 1.1.0 =
* Added global review rating threshold

= 1.0.4 =
* Unified PHP version in README and plugin php to be 7.4

= 1.0.3 =
* Fixed agent code issue when swapping from agency

= 1.0.1 =
* Fixed issue with long names
* Fixed gap between review count and reviews

= 1.0.0 =
* Initial release.
