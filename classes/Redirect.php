<?php
// redirect class is used to redirect the user
class Redirect {
    // to method which just has location
    public static function to($location = null) {
        // if location has been defined 
        if ($location) {
            // pass in an error ex. Redirect::to(404); so we need to know if it is numeric
            if (is_numeric($location)) {
                // switch so we can create as much error casses as much
                switch ($location) {
                    // 404 cas
                    case 404 :
                        // set user header to the 404 not found error
                        header('HTTP/1.0 404 Not Found');
                        // inclued custom template
                        include 'includes/errors/404.php';
                        // exit
                        exit();
                        break;
                }

            }
            // here is where we set the header with the location being the location specified
            header('Location: ' . $location);
            exit();
        }
    }

}
?>