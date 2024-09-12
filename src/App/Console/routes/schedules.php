<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('storage:clean-temp-files-command')->hourly()->runInBackground();