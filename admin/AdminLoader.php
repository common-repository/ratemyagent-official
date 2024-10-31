<?php

namespace Rma\Admin;

use Rma\Admin\Settings\SettingsLoader;
use Rma\Admin\SetupWizard\SetupWizardPage;

class AdminLoader {
	public function __construct() {
		new SettingsLoader();
		new SetupWizardPage();
	}
}
