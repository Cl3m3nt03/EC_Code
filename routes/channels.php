<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('retro.{retroId}', function ($user, $retroId) {
    return true; 
});
