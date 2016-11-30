<?php

namespace App;

use App\Configuration\CallsInteractions;
use App\Configuration\ManagesComponentables;
use App\Configuration\ManagesComponentUpdaters;
use App\Configuration\ManagesDiskStorage;
use App\Configuration\ManagesImageableExtensions;



class App
{

	use CallsInteractions;
	use ManagesComponentUpdaters;
	use ManagesComponentables;
	use ManagesImageableExtensions;
	use ManagesDiskStorage;
}

