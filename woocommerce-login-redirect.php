<?php 
function wc_custom_user_redirect($redirect, $user)
{
    // Get the first of all the roles assigned to the user
    $role      = $user->roles[0];
    $dashboard = admin_url();
    $myaccount = get_permalink(wc_get_page_id('myaccount'));
    if (class_exists('WCV_Vendors') && class_exists('WCVendors_Pro') && WCV_Vendors::is_vendor($user->id)) {
        $redirect = get_permalink(WCVendors_Pro::get_option('dashboard_page_id'))."/product/";
        // $redirect = get_permalink(WCVendors_Pro::get_option('dashboard_page_id'));

    } elseif ($role == 'administrator') {
        //Redirect administrators to the dashboard
        $redirect = $dashboard;
    } elseif ($role == 'shop-manager') {
        //Redirect shop managers to the dashboard
        $redirect = $dashboard;
    } elseif ($role == 'editor') {
        //Redirect editors to the dashboard
        $redirect = $dashboard;
    } elseif ($role == 'author') {
        //Redirect authors to the dashboard
        $redirect = $dashboard;
    } elseif ($role == 'customer' || $role == 'subscriber') {
        //Redirect customers and subscribers to the "My Account" page

        if(isset($_GET['product_id'])){
            $product_id = $_GET['product_id'];
            $product_url = get_permalink( $product_id );
            $redirect = $product_url;
        }
        else{
            $redirect = $myaccount;
        }

        // $redirect = $myaccount;
    } else {
        //Redirect any other role to the previous visited page or, if not available, to the home
        $redirect = wp_get_referer() ? wp_get_referer() : home_url();
    }
    return $redirect;
}
add_filter('woocommerce_login_redirect', 'wc_custom_user_redirect', 10, 2);

?>