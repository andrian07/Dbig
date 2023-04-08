<?php

namespace Config;

// Create a new instance of our RouteCollection class.

$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT

// can override as needed.

if (is_file(SYSTEMPATH . 'Config/Routes.php')) {

    require SYSTEMPATH . 'Config/Routes.php';
}



/*

 * --------------------------------------------------------------------

 * Router Setup

 * --------------------------------------------------------------------

 */

$routes->setDefaultNamespace('App\Controllers');

$routes->setDefaultController('Home');

$routes->setDefaultMethod('index');

$routes->setTranslateURIDashes(false);

$routes->set404Override();

// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps

// where controller filters or CSRF protection are bypassed.

// If you don't want to define all routes, please use the Auto Routing (Improved).

// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.

//$routes->setAutoRoute(false);



/*

 * --------------------------------------------------------------------

 * Route Definitions

 * --------------------------------------------------------------------

 */



// We get a performance increase by specifying the default

// route since we don't have to scan directories.

$routes->get('/', 'Home::index');
$routes->get('verification/(:any)', 'Home::verificationAccount/$1');
$routes->get('reset-password/(:any)', 'Home::resetPassword/$1');


$routes->group('api', static function ($routes) {

    $routes->get('/', 'Api::index');

    $routes->post('login', 'Api::login');

    $routes->post('BannerList', 'Api::getbanner');

    $routes->post('BannerListById', 'Api::getbannerbyid');

    $routes->post('PromoList', 'Api::getpromo');

    $routes->post('PromoListById', 'Api::getpromobyid');

    $routes->post('ProductList', 'Api::getProduct');

    $routes->post('ProductListById', 'Api::getproductbyid');

    $routes->post('CategoryList', 'Api::getcategory');

    $routes->post('BrandList', 'Api::getbrand');

    $routes->post('searchProduct', 'Api::getproductbyname');

    $routes->post('DataUser', 'Api::getdataCustomer');

    $routes->post('ItemPoint', 'Api::getitempoint');

    $routes->post('HistoryPoint', 'Api::historyPoint');

    $routes->post('ExchangePoint', 'Api::exchangePoint');

    $routes->post('ExchangePointProcess', 'Api::exchangePointProcess');

    $routes->post('Register/(:alpha)', 'Api::registerCustomer/$1');

    $routes->post('ChangePass', 'Api::changePass');

    $routes->post('ForgetPass', 'Api::resetPass');
});


$routes->group('api-accounting', static function ($routes) {

    $routes->get('/', 'ApiAccounting::index');

    $routes->post('post-accounting-purchase', 'ApiAccounting::post_accounting_purchase');

    $routes->post('post-accounting-debt-repayment', 'ApiAccounting::post_accounting_debt_repayment');

    $routes->post('post-accounting-retur-purchase', 'ApiAccounting::post_accounting_retur_purchase');

    $routes->post('post-accounting-sales-admin', 'ApiAccounting::post_accounting_sales_admin');

    $routes->post('post-accounting-receivable-repayment', 'ApiAccounting::post_accounting_receivable_repayment');
});


$routes->group('devman', static function ($routes) {

    $routes->get('/', 'Devman::index');

    $routes->get('auth', 'Devman::index');

    $routes->post('auth/login', 'Devman::login', ['filter' => 'csrf']);

    $routes->get('auth/logout', 'Devman::logout');

    $routes->get('log-queries', 'Devman::logQueries', ['filter' => 'devauth']);

    $routes->post('log-queries-table', 'Devman::getLogQueries', ['filter' => 'devauth']);

    $routes->get('log-queries-detail/(:num)', 'Devman::getLogQueriesDetail/$1', ['filter' => 'devauth']);

    $routes->get('install', 'Devman::install', ['filter' => 'devauth']);

    $routes->get('test-email', 'Devman::testEmail', ['filter' => 'devauth']);
});



$routes->group('webmin', static function ($routes) {

    $routes->get('/', 'Webmin\Auth::index');

    $routes->get('auth', 'Webmin\Auth::index');

    $routes->post('auth/login', 'Webmin\Auth::login', ['filter' => 'csrf']);

    $routes->get('auth/logout', 'Webmin\Auth::logout');
});



$routes->group('webmin', ['filter' => 'webminauth'], static function ($routes) {
    $routes->get('profile', 'Webmin\Profile::index');
    $routes->post('profile/update-password', 'Webmin\Profile::updatePassword');
    $routes->post('profile/update-pin', 'Webmin\Profile::updatePin');
});



$routes->group('webmin/category', ['filter' => 'webminauth'], static function ($routes) {

    $routes->get('/', 'Webmin\Category::index');

    $routes->get('getbyid/(:num)', 'Webmin\Category::getById/$1');

    $routes->get('getbyname', 'Webmin\Category::getByName');

    $routes->post('table', 'Webmin\Category::table');

    $routes->post('save/(:alpha)', 'Webmin\Category::save/$1');

    $routes->get('delete/(:num)', 'Webmin\Category::delete/$1');
});





$routes->group('webmin/unit', ['filter' => 'webminauth'], static function ($routes) {

    $routes->get('/', 'Webmin\Unit::index');

    $routes->get('getbyid/(:num)', 'Webmin\Unit::getById/$1');

    $routes->get('getbyname', 'Webmin\Unit::getByName');

    $routes->post('table', 'Webmin\Unit::table');

    $routes->post('save/(:alpha)', 'Webmin\Unit::save/$1');

    $routes->get('delete/(:num)', 'Webmin\Unit::delete/$1');
});



$routes->group('webmin/brand', ['filter' => 'webminauth'], static function ($routes) {

    $routes->get('/', 'Webmin\Brand::index');

    $routes->get('getbyid/(:num)', 'Webmin\Brand::getById/$1');

    $routes->get('getbyname', 'Webmin\Brand::getByName');

    $routes->post('table', 'Webmin\Brand::table');

    $routes->post('save/(:alpha)', 'Webmin\Brand::save/$1');

    $routes->get('delete/(:num)', 'Webmin\Brand::delete/$1');
});



$routes->group('webmin/warehouse', ['filter' => 'webminauth'], static function ($routes) {

    $routes->get('/', 'Webmin\Warehouse::index');

    $routes->post('table', 'Webmin\Warehouse::table');

    $routes->get('getbyid/(:num)', 'Webmin\Warehouse::getById/$1');

    $routes->get('getbycode', 'Webmin\Warehouse::getByCode');

    $routes->get('getbyname', 'Webmin\Warehouse::getByName');

    $routes->post('save/(:alpha)', 'Webmin\Warehouse::save/$1');

    $routes->get('delete/(:num)', 'Webmin\Warehouse::delete/$1');
});



$routes->group('webmin/mapping-area', ['filter' => 'webminauth'], static function ($routes) {

    $routes->get('/', 'Webmin\MappingArea::index');

    $routes->post('table', 'Webmin\MappingArea::table');

    $routes->get('getbyid/(:num)', 'Webmin\MappingArea::getById/$1');

    $routes->get('getbyaddress', 'Webmin\MappingArea::getByAddress');

    $routes->post('save/(:alpha)', 'Webmin\MappingArea::save/$1');

    $routes->get('delete/(:num)', 'Webmin\MappingArea::delete/$1');
});




$routes->group('webmin/password-control', ['filter' => 'webminauth'], static function ($routes) {

    $routes->get('/', 'Webmin\PasswordControl::index');

    $routes->post('table', 'Webmin\PasswordControl::table');

    $routes->get('getbyid/(:num)', 'Webmin\PasswordControl::getById/$1');

    $routes->post('save/(:alpha)', 'Webmin\PasswordControl::save/$1');

    $routes->get('delete/(:num)', 'Webmin\PasswordControl::delete/$1');



    $routes->get('logs', 'Webmin\PasswordControl::logs');

    $routes->post('table-logs', 'Webmin\PasswordControl::tableLogs');
});



$routes->group('webmin/point-reward', ['filter' => 'webminauth'], static function ($routes) {
    $routes->get('/', 'Webmin\PointReward::index');
    $routes->post('table', 'Webmin\PointReward::table');
    $routes->get('getbyid/(:num)', 'Webmin\PointReward::getById/$1');
    $routes->post('save/(:alpha)', 'Webmin\PointReward::save/$1');
    $routes->get('delete/(:num)', 'Webmin\PointReward::delete/$1');
});

$routes->group('webmin/point-exchange', ['filter' => 'webminauth'], static function ($routes) {
    $routes->get('/', 'Webmin\PointExchange::index');
    $routes->post('table', 'Webmin\PointReward::table');
    $routes->get('search-reward', 'Webmin\PointExchange::searchReward');
    $routes->post('exchange', 'Webmin\PointExchange::exchange');
    $routes->post('table-exchange', 'Webmin\PointExchange::tableExchange');
    $routes->post('table-history', 'Webmin\PointExchange::tableHistory');
    $routes->get('cancel-exchange/(:num)', 'Webmin\PointExchange::cancelExchange/$1');
    $routes->get('success-exchange/(:num)', 'Webmin\PointExchange::successExchange/$1');
    $routes->get('detail/(:num)', 'Webmin\PointExchange::detail/$1');
});

$routes->group('webmin/supplier', ['filter' => 'webminauth'], static function ($routes) {

    $routes->get('/', 'Webmin\Supplier::index');

    $routes->post('table', 'Webmin\Supplier::table');

    $routes->get('getbyid/(:num)', 'Webmin\Supplier::getById/$1');

    $routes->get('getbycode', 'Webmin\Supplier::getByCode');

    $routes->get('getbyname', 'Webmin\Supplier::getByName');

    $routes->post('save/(:alpha)', 'Webmin\Supplier::save/$1');

    $routes->get('delete/(:num)', 'Webmin\Supplier::delete/$1');
});


$routes->group('webmin/salesman', ['filter' => 'webminauth'], static function ($routes) {

    $routes->get('/', 'Webmin\Salesman::index');

    $routes->post('table', 'Webmin\Salesman::table');

    $routes->get('getbyid/(:num)', 'Webmin\Salesman::getById/$1');

    $routes->get('getbycode', 'Webmin\Salesman::getByCode');

    $routes->post('save/(:alpha)', 'Webmin\Salesman::save/$1');

    $routes->get('delete/(:num)', 'Webmin\Salesman::delete/$1');
});


$routes->group('webmin/customer', ['filter' => 'webminauth'], static function ($routes) {

    $routes->get('/', 'Webmin\Customer::index');

    $routes->post('table', 'Webmin\Customer::table');

    $routes->get('detail/(:num)', 'Webmin\Customer::detail/$1');

    $routes->get('getbyid/(:num)', 'Webmin\Customer::getById/$1');

    $routes->get('getbycode', 'Webmin\Customer::getByCode');

    $routes->get('getbyemail', 'Webmin\Customer::getByEmail');

    $routes->get('getbyphone', 'Webmin\Customer::getByPhone');

    $routes->post('save/(:alpha)', 'Webmin\Customer::save/$1');

    $routes->get('delete/(:num)', 'Webmin\Customer::delete/$1');

    $routes->get('reset-password/(:num)', 'Webmin\Customer::resetPassword/$1');
});



$routes->group('webmin/product', ['filter' => 'webminauth'], static function ($routes) {

    $routes->get('/', 'Webmin\Product::index');

    $routes->get('detail/(:num)', 'Webmin\Product::detail/$1');

    $routes->post('table', 'Webmin\Product::table');

    $routes->post('save/(:alpha)', 'Webmin\Product::save/$1');

    $routes->get('getbyid/(:num)', 'Webmin\Product::getById/$1');

    $routes->get('getbyname', 'Webmin\Product::getByName');

    $routes->get('delete/(:num)', 'Webmin\Product::delete/$1');

    $routes->get('getbyid/(:num)', 'Webmin\Supplier::getById/$1');

    $routes->get('getbycode', 'Webmin\Supplier::getByCode');

    $routes->get('getbyname', 'Webmin\Supplier::getByName');

    $routes->get('get-product-unit/(:num)', 'Webmin\Product::getProductUnit/$1');

    $routes->get('getitembycode', 'Webmin\Product::getProductUnitByCode');

    $routes->post('save-item/(:alpha)', 'Webmin\Product::saveProductUnit/$1');

    $routes->get('delete-item/(:num)', 'Webmin\Product::deleteProductUnit/$1');



    $routes->post('save-parcel', 'Webmin\Product::saveParcel');

    $routes->get('temp-parcel/(:num)', 'Webmin\Product::getTempParcel/$1');

    $routes->post('add-temp-parcel', 'Webmin\Product::addTempParcel');

    $routes->get('delete-temp-parcel/(:num)/(:num)', 'Webmin\Product::deleteTempParcel/$1/$2');

    $routes->get('search-product', 'Webmin\Product::searchProduct');
});





$routes->group('webmin/voucher', ['filter' => 'webminauth'], static function ($routes) {

    $routes->get('/', 'Webmin\Voucher::index');

    $routes->post('table', 'Webmin\Voucher::table');



    $routes->get('getbyid/(:num)', 'Webmin\Voucher::getById/$1');

    $routes->post('save/(:alpha)', 'Webmin\Voucher::save/$1');

    $routes->get('delete/(:num)', 'Webmin\Voucher::delete/$1');



    $routes->post('table-voucher', 'Webmin\Voucher::tableVoucher');

    $routes->get('generate-voucher/(:num)/(:num)', 'Webmin\Voucher::generateVoucher/$1/$2');

    $routes->get('delete-voucher/(:num)', 'Webmin\Voucher::deleteVoucher/$1');

    $routes->get('export-voucher/(:num)', 'Webmin\Voucher::exportVoucher/$1');
    $routes->get('print-voucher/(:num)', 'Webmin\Voucher::printVoucher/$1');
});


$routes->group('webmin/stock-opname', ['filter' => 'webminauth'], static function ($routes) {
    $routes->get('/', 'Webmin\StockOpname::index');
    $routes->post('table', 'Webmin\StockOpname::table');
    $routes->post('opname-product', 'Webmin\StockOpname::opnameProduct');
    $routes->get('temp/(:num)', 'Webmin\StockOpname::temp/$1');
    $routes->get('temp-opname/(:num)/(:num)', 'Webmin\StockOpname::tempOpname/$1/$2');
    $routes->post('temp-update/(:num)', 'Webmin\StockOpname::tempUpdate/$1');
    $routes->get('temp-delete/(:num)', 'Webmin\StockOpname::tempDelete/$1');
    $routes->post('save', 'Webmin\StockOpname::save');
    $routes->get('detail/(:num)', 'Webmin\StockOpname::detail/$1');
    $routes->get('report/(:num)', 'Webmin\StockOpname::report/$1');
});






$routes->group('webmin/user/user-group', ['filter' => 'webminauth'], static function ($routes) {

    $routes->get('/', 'Webmin\UserGroup::index');

    $routes->get('getbycode/(:alphanum)', 'Webmin\UserGroup::getByCode/$1');

    $routes->get('getbyname', 'Webmin\UserGroup::getByName');

    $routes->post('table', 'Webmin\UserGroup::table');

    $routes->post('save/(:alpha)', 'Webmin\UserGroup::save/$1');

    $routes->get('delete/(:alphanum)', 'Webmin\UserGroup::delete/$1');

    $routes->get('getgrouprole/(:alphanum)', 'Webmin\UserGroup::getGroupRole/$1');

    $routes->post('setgrouprole', 'Webmin\UserGroup::setGroupRole');
});





$routes->group('webmin/user/user-account', ['filter' => 'webminauth'], static function ($routes) {

    $routes->get('/', 'Webmin\UserAccount::index');

    $routes->post('table', 'Webmin\UserAccount::table');

    $routes->get('getbycode/(:alphanum)', 'Webmin\UserAccount::getByCode/$1');

    $routes->get('getbyname', 'Webmin\UserAccount::getByName');

    $routes->post('save/(:alpha)', 'Webmin\UserAccount::save/$1');

    $routes->get('delete/(:alphanum)', 'Webmin\UserAccount::delete/$1');

    $routes->get('reset-password/(:alphanum)', 'Webmin\UserAccount::resetPassword/$1');

    $routes->post('add-fingerprint/(:num)', 'Webmin\UserAccount::addFingerPrint/$1');

    $routes->get('test-fingerprint', 'Webmin\UserAccount::testFingerPrint');
});







/* pembelian */

$routes->group('webmin/purchase-order', ['filter' => 'webminauth'], static function ($routes) {

    $routes->get('/', 'Webmin\Purchase_order::index');

    $routes->post('tblpurchaseorders', 'Webmin\Purchase_order::tblpurchaseorders');

    $routes->get('search-product-bysuplier', 'Webmin\Purchase_order::searchProductBysuplier');

    $routes->post('temp-add', 'Webmin\Purchase_order::tempadd');

    $routes->get('temp-delete/(:alphanum)', 'Webmin\Purchase_order::deleteTemp/$1');

    $routes->get('get-po-temp', 'Webmin\Purchase_order::getPoTemp');

    $routes->get('get-po-footer', 'Webmin\Purchase_order::getPoFooter');

    $routes->get('get-po-tax', 'Webmin\Purchase_order::getTax');

    $routes->post('save/(:alpha)', 'Webmin\Purchase_order::save/$1');

    $routes->get('printinvoice/(:alphanum)', 'Webmin\Purchase_order::printinvoice/$1');

    $routes->get('get-purchase-order-detail/(:alphanum)', 'Webmin\Purchase_order::getPurchaseOrderDetail/$1');

    $routes->get('edit-order/(:alphanum)', 'Webmin\Purchase_order::editOrder/$1');

    $routes->get('cancel-order/(:alphanum)', 'Webmin\Purchase_order::cancelOrder/$1');

    $routes->get('get-submission-detail/(:alphanum)', 'Webmin\Purchase_order::getSubmissionDetail/$1');

    $routes->get('copy-submission/(:alphanum)', 'Webmin\Purchase_order::copySubmission/$1');

    $routes->get('getbyid/(:num)', 'Webmin\Purchase_order::getById/$1');

    $routes->post('update-status-item', 'Webmin\Purchase_order::UpdateStatusItem');
});



$routes->group('webmin/submission', ['filter' => 'webminauth'], static function ($routes) {

    $routes->get('/', 'Webmin\Submission::index');

    $routes->post('tblhdsubmission', 'Webmin\Submission::tblhdsubmission');

    $routes->get('submissiondetaildemo', 'Webmin\Submission::submissiondetaildemo');

    $routes->get('search-product', 'Webmin\Submission::search_product');

    $routes->post('save/(:alpha)', 'Webmin\Submission::save/$1');

    $routes->get('cancel-order/(:alphanum)', 'Webmin\Submission::cancelOrder/$1');

    $routes->post('decline-order', 'Webmin\Submission::declineOrder');

    $routes->get('search-product-submission', 'Webmin\Submission::searchProductSubmission');

    $routes->get('get-submission-detail/(:alphanum)', 'Webmin\Submission::getSubmissionDetail/$1');

    $routes->get('getbyid/(:num)', 'Webmin\Submission::getById/$1');
});


$routes->group('webmin/purchase', ['filter' => 'webminauth'], static function ($routes) {

    $routes->get('/', 'Webmin\Purchase::index');

    $routes->get('get-no-po', 'Webmin\Purchase::getNoPo');

    $routes->get('copy-purchase-order/(:alphanum)', 'Webmin\Purchase::copyPurchaseOrder/$1');

    $routes->post('tblpurchase', 'Webmin\Purchase::tblpurchase');

    $routes->post('temp-add', 'Webmin\Purchase::tempadd');

    $routes->get('clear-temp', 'Webmin\Purchase::clearTemp');

    $routes->get('temp-delete/(:alphanum)', 'Webmin\Purchase::deleteTemp/$1');

    $routes->get('get-purchase-detail/(:alphanum)', 'Webmin\Purchase::getPurchaseDetail/$1');

    $routes->get('get-purchase-temp', 'Webmin\Purchase::getPurchaseTemp');

    $routes->get('get-purchase-footer', 'Webmin\Purchase::getPurchaseFooter');

    $routes->get('get-purchase-tax', 'Webmin\Purchase::getTax');

    $routes->post('save/(:alpha)', 'Webmin\Purchase::save/$1');
});

$routes->group('webmin/retur', ['filter' => 'webminauth'], static function ($routes) {

    $routes->get('/', 'Webmin\Retur\Retur::index');

    $routes->get('get-no-purchase', 'Webmin\Retur\Retur::searchPurchaseBysuplier');

    $routes->get('search-product-noinvoice', 'Webmin\Retur\Retur::searchProductByInvoice');

    $routes->post('temp-add', 'Webmin\Retur\Retur::tempadd');

    $routes->get('get-retur-temp', 'Webmin\Retur\Retur::getReturTemp');

    $routes->get('temp-delete/(:alphanum)', 'Webmin\Retur\Retur::deleteTemp/$1');

    $routes->get('get-retur-footer', 'Webmin\Retur\Retur::getReturFooter');

    $routes->post('save/(:alpha)', 'Webmin\Retur\Retur::save/$1');

    $routes->post('tblreturpurchase', 'Webmin\Retur\Retur::tblreturpurchase');

    $routes->get('get-retur-detail/(:alphanum)', 'Webmin\Retur\Retur::getReturDetail/$1');

    $routes->get('edit-retur-purchase/(:alphanum)', 'Webmin\Retur\Retur::editReturPurchase/$1');

    $routes->get('getByid/(:alphanum)', 'Webmin\Retur\Retur::getByid/$1');

    $routes->post('savepayment', 'Webmin\Retur\Retur::savepayment');

    $routes->get('cancel-retur/(:alphanum)', 'Webmin\Retur\Retur::cancelRetur/$1');

    $routes->get('printinvoice/(:alphanum)', 'Webmin\Retur\Retur::printInvoice/$1');

});


$routes->group('webmin/consignment', ['filter' => 'webminauth'], static function ($routes) {

    $routes->get('purchase-order-consignment', 'Webmin\Consignment\Consignment::purchaseOrderConsignment');

    $routes->get('printinvoice', 'Webmin\Consignment\Consignment::printinvoice');

    $routes->post('tblhdpoconsignment', 'Webmin\Consignment\Consignment::tblhdPoConsignment');

    $routes->post('tblhdInputConsignment', 'Webmin\Consignment\Consignment::tblhdInputConsignment');

    $routes->get('stock-input-consignment', 'Webmin\Consignment\Consignment::stockInputConsignment');

    $routes->post('temp-add', 'Webmin\Consignment\Consignment::tempadd');

    $routes->post('temp-add-input', 'Webmin\Consignment\Consignment::tempaddinput');

    $routes->get('get-consignment-temp', 'Webmin\Consignment\Consignment::getConsignmentTemp');

    $routes->get('get-input-consignment-temp', 'Webmin\Consignment\Consignment::getInputConsignmentTemp');

    $routes->get('temp-delete/(:alphanum)', 'Webmin\Consignment\Consignment::deleteTemp/$1');

    $routes->get('temp-delete-cons/(:alphanum)', 'Webmin\Consignment\Consignment::deleteTempCons/$1');

    $routes->post('save/(:alpha)', 'Webmin\Consignment\Consignment::save/$1');

    $routes->post('save-input/(:alpha)', 'Webmin\Consignment\Consignment::saveInput/$1');

    $routes->get('copy-purchase-order-consignment/(:alphanum)', 'Webmin\Consignment\Consignment::copyPurchaseOrderConsignment/$1');

    $routes->get('get-consignment-po-detail/(:alphanum)', 'Webmin\Consignment\Consignment::getConsignmentPoDetail/$1');

    $routes->get('recap-consignment', 'Webmin\Consignment\Consignment::recapConsignment');

    $routes->get('edit-po-consignment/(:alphanum)', 'Webmin\Consignment\Consignment::editPoConsignment/$1');

    $routes->get('cancel-po-order/(:alphanum)', 'Webmin\Consignment\Consignment::cancelPoOrder/$1');
});

/* end pembelian */





/* penjualan admin */

$routes->group('webmin/sales-admin', ['filter' => 'webminauth'], static function ($routes) {

    $routes->get('/', 'Webmin\Sales_admin::index');

    $routes->post('tblsalesadmin', 'Webmin\Sales_admin::tblsalesadmin');

    $routes->get('search-product', 'Webmin\Sales_admin::searchProduct');

    $routes->get('print-invoice/(:alphanum)', 'Webmin\Sales_admin::printinvoice/$1');

    $routes->get('printdispatch/(:alphanum)', 'Webmin\Sales_admin::printdispatch/$1');

    $routes->post('temp-add', 'Webmin\Sales_admin::tempadd');

    $routes->get('temp-delete/(:alphanum)', 'Webmin\Sales_admin::deleteTemp/$1');

    $routes->get('get-salesadmin-temp', 'Webmin\Sales_admin::getSalesadminTemp');

    $routes->get('get-salesadmin-footer', 'Webmin\Sales_admin::getSalesadminFooter');

    $routes->get('get-sales-admin-detail/(:alphanum)', 'Webmin\Sales_admin::getSalesAdminDetail/$1');

    $routes->post('save/(:alpha)', 'Webmin\Sales_admin::save/$1');

    $routes->get('edit-salesadmin/(:alphanum)', 'Webmin\Sales_admin::editSalesadmin/$1');
});

/* end penjualan admin */

/* penjualan pos */
$routes->group('webmin/sales-pos', ['filter' => 'webminauth'], static function ($routes) {
    $routes->get('/', 'Webmin\SalesPos::index');
    $routes->get('getbyid/(:num)', 'Webmin\SalesPos::getById/$1');
    $routes->get('getdetailbyid/(:num)', 'Webmin\SalesPos::getDetailById/$1');
    $routes->post('table', 'Webmin\SalesPos::table');
    $routes->post('table-detail-sales', 'Webmin\SalesPos::tableDetailSales');
    $routes->post('change-salesman/(:num)/(:num)', 'Webmin\SalesPos::changeSalesman/$1/$2');
});
/* end penjualan pos */




$routes->group('webmin/payment', ['filter' => 'webminauth'], static function ($routes) {

    /* Pelunasan Hutang */

    $routes->get('debt-repayment', 'Webmin\Payment\Debt_repayment::index');

    $routes->post('tbldebtrepaymenthistory', 'Webmin\Payment\Debt_repayment::tbl_debtrepaymenthistory');

    $routes->post('tbldebtrepayment', 'Webmin\Payment\Debt_repayment::tbl_debtrepayment');

    $routes->get('tbltemprepayment/(:alphanum)', 'Webmin\Payment\Debt_repayment::tbltemprepayment/$1');

    $routes->post('copy_data_temp', 'Webmin\Payment\Debt_repayment::copyDataTemp');

    $routes->post('temp-add', 'Webmin\Payment\Debt_repayment::tempadd');

    $routes->get('get-payment-footer', 'Webmin\Payment\Debt_repayment::getPaymentFooter');

    $routes->post('save/(:alpha)', 'Webmin\Payment\Debt_repayment::save/$1');

    $routes->get('get-debt-history-detail/(:alphanum)', 'Webmin\Payment\Debt_repayment::getDebtHistoryDetail/$1');

    $routes->get('get-receivable-history-detail/(:alphanum)', 'Webmin\Payment\Receivable_repayment::getReceivableHistoryDetail/$1');
    

    /* End Pelunasan Hutang */

    /* Pelunasan Piutang */

    $routes->get('receivable-repayment', 'Webmin\Payment\Receivable_repayment::index');

    $routes->post('tblreceivablerepayment', 'Webmin\Payment\Receivable_repayment::tbl_receivable_repayment');

    $routes->post('copy_data_temp_repayment', 'Webmin\Payment\Receivable_repayment::copyDataTempRepayment');

    $routes->post('temp-receivable-add', 'Webmin\Payment\Receivable_repayment::tempadd');

    $routes->post('save-receivable/(:alpha)', 'Webmin\Payment\Receivable_repayment::saveReceivable/$1');

    $routes->get('get-receivable-footer', 'Webmin\Payment\Receivable_repayment::getReceivableFooter');

    $routes->post('tblreceivablehistory', 'Webmin\Payment\Receivable_repayment::tbl_receivablehistory');





    /* End Pelunasan Piutang */
});


/* Mobile Apps */
$routes->group('webmin/mobileapps/banner', ['filter' => 'webminauth'], static function ($routes) {
    $routes->get('/', 'Webmin\MobileApps\Banner::index');
    $routes->post('table', 'Webmin\MobileApps\Banner::table');
    $routes->get('getbyid/(:num)', 'Webmin\MobileApps\Banner::getById/$1');
    $routes->post('save/(:alpha)', 'Webmin\MobileApps\Banner::save/$1');
    $routes->get('delete/(:num)', 'Webmin\MobileApps\Banner::delete/$1');
});

$routes->group('webmin/mobileapps/promo', ['filter' => 'webminauth'], static function ($routes) {
    $routes->get('/', 'Webmin\MobileApps\Promo::index');
    $routes->post('table', 'Webmin\MobileApps\Promo::table');
    $routes->get('getbyid/(:num)', 'Webmin\MobileApps\Promo::getById/$1');
    $routes->post('save/(:alpha)', 'Webmin\MobileApps\Promo::save/$1');
    $routes->get('delete/(:num)', 'Webmin\MobileApps\Promo::delete/$1');
});

/* end Mobile*/


/* Stock Transfer*/

$routes->group('webmin/stock-transfer', ['filter' => 'webminauth'], static function ($routes) {

    $routes->get('/', 'Webmin\Stocktransfer\Stocktransfer::index');

    $routes->get('search-product-transfer', 'Webmin\Stocktransfer\Stocktransfer::searchProductTransfer');

    $routes->post('temp-add', 'Webmin\Stocktransfer\Stocktransfer::tempadd');

    $routes->get('get-transfer-temp', 'Webmin\Stocktransfer\Stocktransfer::getTransferTemp');

    $routes->get('temp-delete/(:num)', 'Webmin\Stocktransfer\Stocktransfer::tempDelete/$1');

    $routes->post('save/(:alpha)', 'Webmin\Stocktransfer\Stocktransfer::save/$1');

    $routes->post('tblstocktransfer', 'Webmin\Stocktransfer\Stocktransfer::tblstocktransfer');

    $routes->get('get-stock-transfer-detail/(:alphanum)', 'Webmin\Stocktransfer\Stocktransfer::getStockTransferDetail/$1');
});

/* end Stock Transfer*/


/* Report */

$routes->group('webmin/report', ['filter' => 'webminauth'], static function ($routes) {

    /* Section Utility */

    $routes->get('/', 'Webmin\Report\Report::index');

    $routes->get('view-barcode-generate', 'Webmin\Report\Report::viewBarcodeGenerate');

    $routes->get('view-price-tag', 'Webmin\Report\Report::viewPriceTag');

    $routes->get('barcode-generate', 'Webmin\Report\Report::barcodeGenerate');

    $routes->get('price-tag', 'Webmin\Report\Report::priceTag');

    /* Section Customer */

    $routes->get('view-customer-list', 'Webmin\Report\ReportCustomer::viewCustomerList');

    $routes->get('customer-list', 'Webmin\Report\ReportCustomer::customerList');

    $routes->get('view-point-exchange-list', 'Webmin\Report\ReportCustomer::viewPointExchangeList');

    $routes->get('point-exchange-list', 'Webmin\Report\ReportCustomer::pointExchangeList');

    $routes->get('view-customer-receivable-list', 'Webmin\Report\ReportCustomer::viewCustomerReceivableList');

    $routes->get('customer-receivable-list', 'Webmin\Report\ReportCustomer::customerReceivableList');

    $routes->get('view-customer-receivable-receipt', 'Webmin\Report\ReportCustomer::viewCustomerReceivableReceipt');

    $routes->get('customer-receivable-receipt', 'Webmin\Report\ReportCustomer::customerReceivableReceipt');



    /* Section  Inventory */

    $routes->get('view-stock-list', 'Webmin\Report\ReportInventory::viewStockList');

    $routes->get('stock-list', 'Webmin\Report\ReportInventory::stockList');

    $routes->get('view-stock-card', 'Webmin\Report\ReportInventory::viewStockCard');

    $routes->get('stock-card', 'Webmin\Report\ReportInventory::stockCard');

    $routes->get('view-stock-opname-list', 'Webmin\Report\ReportInventory::viewStockOpnameList');

    $routes->get('stock-opname-list', 'Webmin\Report\ReportInventory::stockOpnameList');

    $routes->get('view-stock-transfer-list', 'Webmin\Report\ReportInventory::viewStockTransferList');

    $routes->get('stock-transfer-list', 'Webmin\Report\ReportInventory::stockTransferList');



    $routes->get('view-dead-stock-list', 'Webmin\Report\ReportInventory::viewDeadStockList');

    $routes->get('dead-stock-list', 'Webmin\Report\ReportInventory::deadStockList');

    $routes->get('view-exp-stock-list', 'Webmin\Report\ReportInventory::viewExpStockList');

    $routes->get('exp-stock-list', 'Webmin\Report\ReportInventory::expStockList');


    /* section purchase */

    $routes->get('view-po-list', 'Webmin\Report\ReportPurchase::viewPOList');

    $routes->get('po-list', 'Webmin\Report\ReportPurchase::POList');

    $routes->get('view-purchase-list', 'Webmin\Report\ReportPurchase::viewPurchaseList');

    $routes->get('purchase-list', 'Webmin\Report\ReportPurchase::PurchaseList');


    /* end section purchase */

    /* section Konsinyasi */

    $routes->get('view-po-consignment-list', 'Webmin\Report\ReportPurchase::viewPOConsignmentList');

    $routes->get('po-consignment-list', 'Webmin\Report\ReportPurchase::POConsignmentList');

    $routes->get('view-consignment-stockin', 'Webmin\Report\ReportPurchase::viewConsignmentStockin');

    $routes->get('consignment-stockin', 'Webmin\Report\ReportPurchase::ConsignmentStockin');


    /* end section Konsinyasi */

    /* section Retur Purchase */

    $routes->get('view-retur-purchase-list', 'Webmin\Report\ReportPurchase::viewReturPurchaseList');

    $routes->get('retur-purchase-list', 'Webmin\Report\ReportPurchase::returPurchaseList');

    /* end section Retur Purchase */


    /* section debt */

    //$routes->get('view-debt-balance-list', 'Webmin\Report\ReportDebt::viewDebtBalanceList');

    $routes->get('view-debt-card-list', 'Webmin\Report\ReportDebt::viewDebtCardList');

    $routes->get('cart-debt-list', 'Webmin\Report\ReportDebt::cartDebtList');

    $routes->get('view-debt-pending-list', 'Webmin\Report\ReportDebt::viewDebtPendingList');

    $routes->get('debt-pending-list', 'Webmin\Report\ReportDebt::debtPendingList');

    $routes->get('view-debt-duedate-list', 'Webmin\Report\ReportDebt::viewDebtDuedateList');

    $routes->get('debt-duedate-list', 'Webmin\Report\ReportDebt::debtDuedateList');

    $routes->get('view-debt-list', 'Webmin\Report\ReportDebt::viewDebtList');

    $routes->get('debt-list', 'Webmin\Report\ReportDebt::debtList');

    /* end section debt */

    /* Section Sales */

    $routes->get('view-sales-list', 'Webmin\Report\ReportPos::index');

    $routes->get('sales-list', 'Webmin\Report\ReportPos::salesList');
    $routes->get('detail-sales-list', 'Webmin\Report\ReportPos::detailSalesList');

    $routes->get('view-sales-list-group-salesman', 'Webmin\Report\ReportPos::viewSalesListGroupSalesman');
    $routes->get('sales-list-group-salesman', 'Webmin\Report\ReportPos::salesListGroupSalesman');
    $routes->get('detail-sales-list-group-salesman', 'Webmin\Report\ReportPos::detailSalesListGroupSalesman');

    $routes->get('view-sales-list-group-payment', 'Webmin\Report\ReportPos::viewSalesListGroupPayment');
    $routes->get('sales-list-group-payment', 'Webmin\Report\ReportPos::salesListGroupPayment');


    $routes->get('view-project-sales-list', 'Webmin\Report\ReportSales::viewProjectSalesList');

    $routes->get('project-sales-list', 'Webmin\Report\ReportSales::projectSalesList');

    $routes->get('view-project-sales-list-group-salesman', 'Webmin\Report\ReportSales::viewProjectSalesListGroupSalesman');

    $routes->get('project-sales-list-group-salesman', 'Webmin\Report\ReportSales::projectSalesListGroupSalesman');

    $routes->get('view-project-sales-list-group-customer', 'Webmin\Report\ReportSales::viewProjectSalesListGroupCustomer');

    $routes->get('project-sales-list-group-customer', 'Webmin\Report\ReportSales::projectSalesListGroupCustomer');
});

/* End Report */

/* Select2 */

$routes->group('webmin/select', ['filter' => 'webminauth'], static function ($routes) {
    $routes->get('store', 'Webmin\Select::store');

    $routes->get('user-group', 'Webmin\Select::userGroup');

    $routes->get('user-account', 'Webmin\Select::userAccount');

    $routes->get('unit', 'Webmin\Select::unit');

    $routes->get('product', 'Webmin\Select::product');

    $routes->get('product-unit', 'Webmin\Select::productUnit');

    $routes->get('category', 'Webmin\Select::category');

    $routes->get('salesman', 'Webmin\Select::salesman');

    $routes->get('brand', 'Webmin\Select::brand');

    $routes->get('supplier', 'Webmin\Select::supplier');

    $routes->get('customer', 'Webmin\Select::customer');

    $routes->get('pc/provinces', 'Webmin\Select::pcProvinces');

    $routes->get('pc/cities', 'Webmin\Select::pcCities');

    $routes->get('pc/districts', 'Webmin\Select::pcDistricts');

    $routes->get('pc/subdistricts', 'Webmin\Select::pcSubDistricts');

    $routes->get('mapping-area', 'Webmin\Select::mappingArea');

    $routes->get('warehouse', 'Webmin\Select::warehouse');

    $routes->get('no-po', 'Webmin\Select::noPo');

    $routes->get('no-submission', 'Webmin\Select::noSubmission');

    $routes->get('no-submission-consignment', 'Webmin\Select::noSubmissionConsignment');

    $routes->get('no-po-consignment', 'Webmin\Select::noPoConsignment');

    $routes->get('no-purchase', 'Webmin\Select::noPurchase');

    $routes->get('no-purchase-report', 'Webmin\Select::noPurchaseReport');

    $routes->get('payment-method', 'Webmin\Select::payment_method');

    $routes->get('salesman', 'Webmin\Select::salesman');
});

/* END Select2 */




/* api pos */
$routes->group('api-pos', static function ($routes) {
    $routes->get('/', 'ApiPos::index');
    $routes->get('get-datetime/(:alphanum)', 'ApiPos::getUpdateTime/$1');
    $routes->post('save-update-time/(:alphanum)', 'ApiPos::saveUpdateTime/$1');
    $routes->post('download/(:alphanum)', 'ApiPos::downloadData/$1');
    $routes->post('upload/(:alphanum)', 'ApiPos::uploadData/$1');
    $routes->get('post-to-accounting', 'ApiPos::postToAccounting');
});
/* end api pos */






/*

 * --------------------------------------------------------------------

 * Additional Routing

 * --------------------------------------------------------------------

 *

 * There will often be times that you need additional routing and you

 * need it to be able to override any defaults in this file. Environment

 * based routes is one such time. require() additional route files here

 * to make that happen.

 *

 * You will have access to the $routes object within that file without

 * needing to reload it.

 */

if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {

    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
