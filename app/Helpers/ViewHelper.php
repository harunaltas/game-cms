<?php

namespace App\Helpers;

class ViewHelper {
    public static function renderPlayerActions($row) {
        return view('components.player_actions', $row)->render();
    }
}
