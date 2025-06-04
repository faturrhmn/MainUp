<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\maintenance\MaintenanceController;

class AccountSettingsNotifications extends Controller
{
  public function index()
  {
    $allNotifications = MaintenanceController::getMaintenanceNotifications();
    return view('content.pages.pages-account-settings-notifications', compact('allNotifications'));
  }
}
