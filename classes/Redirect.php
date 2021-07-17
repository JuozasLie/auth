<?php
class Redirect {
    public static function to($location = null){
        if ($location) {
            if(is_numeric($location)){
                switch ($location){
                    case 404:
                        http_response_code(404);
                        include 'includes/errors/404.php';
                        exit();
                }
            }
            header('Location: '. $location);
            exit();
        }
    }
}