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



$routes->group('devman', static function ($routes) {

    $routes->get('/', 'Devman::index');

    $routes->get('auth', 'Devman::index');

    $routes->post('auth/login', 'Devman::login', ['filter' => 'csrf']);

    $routes->get('auth/logout', 'Devman::logout');



    $routes->get('log-queries', 'Devman::logQueries', ['filter' => 'devauth']);

    $routes->post('log-queries-table', 'Devman::getLogQueries', ['filter' => 'devauth']);

    $routes->get('log-queries-detail/(:num)', 'Devman::getLogQueriesDetail/$1', ['filter' => 'devauth']);

});



$routes->group('webmin', static function ($routes) {

    $routes->get('/', 'Webmin\Auth::index');

    $routes->get('auth', 'Webmin\Auth::index');

    $routes->post('auth/login', 'Webmin\Auth::login', ['filter' => 'csrf']);

    $routes->get('auth/logout', 'Webmin\Auth::logout');

});



$routes->group('webmin', ['filter' => 'webminauth'], static function ($routes) {

    $routes->get('profile', 'Webmin\Profile::index');

    $routes->get('profile/update-password', 'Webmin\Profile::update_password');

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







$routes->group('webmin/supplier', ['filter' => 'webminauth'], static function ($routes) {

    $routes->get('/', 'Webmin\Supplier::index');

    $routes->post('table', 'Webmin\Supplier::table');

    $routes->get('getbyid/(:num)', 'Webmin\Supplier::getById/$1');

    $routes->get('getbycode', 'Webmin\Supplier::getByCode');

    $routes->get('getbyname', 'Webmin\Supplier::getByName');

    $routes->post('save/(:alpha)', 'Webmin\Supplier::save/$1');

    $routes->get('delete/(:num)', 'Webmin\Supplier::delete/$1');

});



$routes->group('webmin/customer', ['filter' => 'webminauth'], static function ($routes) {

    $routes->get('/', 'Webmin\Customer::index');

    $routes->post('table', 'Webmin\Customer::table');

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

    $routes->get('copy-submission/(:alphanum)', 'Webmin\Purchase_order::copySubmission/$1');

});



$routes->group('webmin/submission', ['filter' => 'webminauth'], static function ($routes) {

    $routes->get('/', 'Webmin\Submission::index');

    $routes->post('tblhdsubmission', 'Webmin\Submission::tblhdsubmission');

    $routes->get('get-submission-temp', 'Webmin\Submission::getSubmissionTemp');

    $routes->get('temp-delete/(:alphanum)', 'Webmin\Submission::deleteTemp/$1');

    $routes->get('submissiondetaildemo', 'Webmin\Submission::submissiondetaildemo');

    $routes->post('tbltempsubmission', 'Webmin\Submission::tbltempsubmission');

    $routes->get('search-product', 'Webmin\Submission::search_product');

    $routes->post('temp-add', 'Webmin\Submission::tempadd');

    $routes->post('save/(:alpha)', 'Webmin\Submission::save/$1');

    $routes->get('get-submission-detail/(:alphanum)', 'Webmin\Submission::getSubmissionDetail/$1');

    //$routes->get('get-submission-edit/(:alphanum)', 'Webmin\Submission::getSubmissionEdit/$1');

    $routes->get('edit-order/(:alphanum)', 'Webmin\Submission::editOrder/$1');

    $routes->get('cancel-order/(:alphanum)', 'Webmin\Submission::cancelOrder/$1');

    $routes->post('temp-add', 'Webmin\Purchase_order::tempadd');
});



$routes->group('webmin/purchase', ['filter' => 'webminauth'], static function ($routes) {

    $routes->get('/', 'Webmin\Purchase::index');

    $routes->get('retur-purchase', 'Webmin\Purchase::returpurchase');

    $routes->get('get-no-po', 'Webmin\Purchase::getNoPo');

    $routes->get('copy-purchase-order/(:alphanum)', 'Webmin\Purchase::copyPurchaseOrder/$1');

    $routes->post('tblpurchase', 'Webmin\Purchase::tblpurchase');

    $routes->post('temp-add', 'Webmin\Purchase::tempadd');

    $routes->get('temp-delete/(:alphanum)', 'Webmin\Purchase::deleteTemp/$1');

    $routes->get('get-purchase-detail/(:alphanum)', 'Webmin\Purchase::getPurchaseDetail/$1');

    $routes->get('get-purchase-temp', 'Webmin\Purchase::getPurchaseTemp');

    $routes->get('get-purchase-footer', 'Webmin\Purchase::getPurchaseFooter');

    $routes->get('get-purchase-tax', 'Webmin\Purchase::getTax');

    $routes->post('save/(:alpha)', 'Webmin\Purchase::save/$1');


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


});

/* end pembelian */





/* penjualan admin */

$routes->group('webmin/sales-admin', ['filter' => 'webminauth'], static function ($routes) {

    $routes->get('/', 'Webmin\Sales_admin::index');

    $routes->get('printinvoice', 'Webmin\Sales_admin::printinvoice');

    $routes->get('printdispatch', 'Webmin\Sales_admin::printdispatch');

});

/* end penjualan admin */



/* Mobile*/

$routes->group('webmin/mobileapps', ['filter' => 'webminauth'], static function ($routes) {

    $routes->get('/', 'Webmin\Mobileapps\Mobileapps::index');

    $routes->post('tablebanner', 'Webmin\Mobileapps\Mobileapps::tablebanner');

    $routes->post('tablepromo', 'Webmin\Mobileapps\Mobileapps::tablepromo');

    $routes->get('mobileapps-banner', 'Webmin\Mobileapps\Mobileapps::mobileappsBanner');

    $routes->get('mobileapps-promo', 'Webmin\Mobileapps\Mobileapps::mobileappsPromo');

    $routes->post('savebanner/(:alpha)', 'Webmin\Mobileapps\Mobileapps::savebanner/$1');

    $routes->post('savepromo/(:alpha)', 'Webmin\Mobileapps\Mobileapps::savepromo/$1');

    $routes->get('getbyid/(:num)', 'Webmin\Mobileapps\Mobileapps::getById/$1');

    $routes->get('deletebanner/(:num)', 'Webmin\Mobileapps\Mobileapps::deletebanner/$1');

    $routes->get('deletepromo/(:num)', 'Webmin\Mobileapps\Mobileapps::deletepromo/$1');

});

/* end Mobile*/



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





    /* Section Sales */

    $routes->get('view-sales-list', 'Webmin\Report\ReportSales::index');

    $routes->get('sales-list', 'Webmin\Report\ReportSales::salesList');

    $routes->get('view-sales-list-group-salesman', 'Webmin\Report\ReportSales::viewSalesListGroupSalesman');

    $routes->get('sales-list-group-salesman', 'Webmin\Report\ReportSales::salesListGroupSalesman');

    $routes->get('view-sales-list-group-payment', 'Webmin\Report\ReportSales::viewSalesListGroupPayment');

    $routes->get('sales-list-group-payment', 'Webmin\Report\ReportSales::salesListGroupPayment');



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

    $routes->get('category', 'Webmin\Select::category');

    $routes->get('brand', 'Webmin\Select::brand');

    $routes->get('supplier', 'Webmin\Select::supplier');

    $routes->get('pc/provinces', 'Webmin\Select::pcProvinces');

    $routes->get('pc/cities', 'Webmin\Select::pcCities');

    $routes->get('pc/districts', 'Webmin\Select::pcDistricts');

    $routes->get('pc/subdistricts', 'Webmin\Select::pcSubDistricts');

    $routes->get('mapping-area', 'Webmin\Select::mappingArea');

    $routes->get('warehouse', 'Webmin\Select::warehouse');

    $routes->get('no-po', 'Webmin\Select::noPo');

    $routes->get('no-submission', 'Webmin\Select::noSubmission');

    $routes->get('no-po-consignment', 'Webmin\Select::noPoConsignment');

    $routes->get('payment-method', 'Webmin\Select::payment_method');

   

});

/* END Select2 */



/* POS */

$routes->group('pos', static function ($routes) {

    $routes->get('/', 'Pos\Auth::index');

    $routes->get('auth', 'Pos\Auth::index');

    $routes->post('auth/login', 'Pos\Auth::login', ['filter' => 'csrf']);

    $routes->get('auth/logout', 'Pos\Auth::logout');

});





$routes->group('pos', ['filter' => 'posauth'], static function ($routes) {

    //$routes->get('profile', 'Webmin\Profile::index');

    //$routes->get('profile/update-password', 'Webmin\Profile::update_password');

    $routes->get('dashboard', 'Pos\Dashboard::index');

    $routes->get('sales', 'Pos\Sales::index');

    $routes->get('sales-return', 'Pos\Sales_return::index');



    $routes->get('view-sales-recap', 'Pos\Dashboard::viewSalesRecap');

    $routes->get('sales-recap', 'Pos\Dashboard::salesRecap');



    $routes->get('view-sales-receipt', 'Pos\Dashboard::viewSalesReceipt');

    $routes->get('view-sales-return-receipt', 'Pos\Dashboard::viewSalesReturnReceipt');

    $routes->get('sales-receipt/(:alpha)', 'Pos\Dashboard::salesReceipt/$1');

    $routes->get('sales-return-receipt', 'Pos\Dashboard::salesReturnReceipt');

});



$routes->get('pos/price-checker', 'Pos\Utility::priceChecker');

$routes->get('pos/customer-display', 'Pos\Utility::customerDisplay');

/* END POS */





/* Eric Demo */

$routes->group('webmin', ['filter' => 'webminauth'], static function ($routes) {



    //$routes->get('customer', 'Webmin\EricDemo::customer');



    //$routes->get('supplier', 'Webmin\EricDemo::supplier');

    //$routes->get('product', 'Webmin\EricDemo::product');

    //$routes->get('product/detail', 'Webmin\EricDemo::productDetail');

    //$routes->get('product/parcel-detail', 'Webmin\EricDemo::parcelDetail');



    $routes->get('point-reward', 'Webmin\EricDemo::pointReward');

    $routes->get('exchange-point', 'Webmin\EricDemo::exchangePoint');

    $routes->get('exchange-point/v2', 'Webmin\EricDemo::exchangePointV2');

    $routes->get('exchange-point/detail', 'Webmin\EricDemo::exchangePointDetail');



    //$routes->get('password-control', 'Webmin\EricDemo::passwordControl');

    //$routes->get('password-control/logs', 'Webmin\EricDemo::passwordControlLogs');

    //$routes->get('voucher', 'Webmin\EricDemo::voucher');





    $routes->get('debt-repayment', 'Webmin\EricDemo::debtRepayment');

    $routes->get('debt-repayment/detail', 'Webmin\EricDemo::debtRepaymentDetail');



    $routes->get('receivable-repayment', 'Webmin\EricDemo::receivableRepayment');

    $routes->get('receivable-repayment/detail', 'Webmin\EricDemo::receivableRepaymentDetail');



    $routes->get('consignment-repayment', 'Webmin\EricDemo::consignmentRepayment');

    $routes->get('consignment-repayment/invoice', 'Webmin\EricDemo::consignmentRepaymentInvoice');

    $routes->get('consignment-repayment/detail', 'Webmin\EricDemo::consignmentRepaymentDetail');





    $routes->get('stock-opname', 'Webmin\EricDemo::stockOpname');

    $routes->get('stock-opname/detail', 'Webmin\EricDemo::stockOpnameDetail');

    $routes->get('stock-opname/report', 'Webmin\EricDemo::stockOpnameReport');





    $routes->get('stock-transfer', 'Webmin\EricDemo::stockTransfer');

    $routes->get('stock-transfer/detail', 'Webmin\EricDemo::stockTransferDetail');

    $routes->get('stock-transfer/report', 'Webmin\EricDemo::stockTransferReport');



    $routes->get('report/product-sales-recap', 'Webmin\EricDemo::reportSalesProductRecap');

    $routes->get('report/view-product-sales-recap', 'Webmin\EricDemo::viewReportSalesProductRecap');

});

/* End Eric Demo */





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

