CREATE DATABASE IF NOT EXISTS p33686118;
USE p33686118;

CREATE TABLE src(
	id				INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name			CHAR(50),
	phone			CHAR(20),
	detailAddress	CHAR(200),
	districtName	CHAR(150),
	cityName		CHAR(150),
	provinceName	CHAR(150),
	postalCode		CHAR(20),
	created_date	DATETIME
);

CREATE TABLE dst(
	id				INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name			CHAR(50),
	phone			CHAR(20),
	detailAddress	CHAR(200),
	districtName	CHAR(150),
	cityName		CHAR(150),
	provinceName	CHAR(150),
	postalCode		CHAR(20),
	cod				INT,
	created_date	DATETIME
);

CREATE TABLE tracking(
	id					INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    pno					CHAR(20),
	state				INT,
	dstName				CHAR(50),
	dstPhone			CHAR(20),
	dstAddress			CHAR(200),
	codEnabled			INT,
	codAmount			INT,
	ordersId			INT,
	notifyTrackingId	INT,
	created_date		DATETIME,
	lastupdate			DATETIME
);

CREATE TABLE orders(
	id						INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	mchId					CHAR(32),
	nonceStr				CHAR(32),
	signStr					CHAR(64),
	outTradeNo				CHAR(64),
	expressCategory			INT,
	warehouseNo				CHAR(32),
	srcName					CHAR(50),
	srcPhone				CHAR(20),
	srcProvinceName			CHAR(150),
	srcCityName				CHAR(150),
	srcDistrictName			CHAR(150),
	srcPostalCode			CHAR(20),
	srcDetailAddress		CHAR(200),
	dstName					CHAR(50),
	dstPhone				CHAR(20),
	dstProvinceName			CHAR(150),
	dstCityName				CHAR(150),
	dstDistrictName			CHAR(150),
	dstPostalCode			CHAR(20),
	dstDetailAddress		CHAR(200),
	articleCategory			INT,
	weight					INT,
	width					INT,
	length					INT,
	height					INT,
	insured					INT,
	insureDeclareValue		INT,
	freightInsureEnabled	INT,
	opdInsureEnabled		INT,
	codEnabled				INT,
	codAmount				INT,
	remark					CHAR(200),
	created_date			DATETIME
);

CREATE TABLE ordersResponse(
	id						INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	ordersId				INT,
	pno						CHAR(20),
	mchId					CHAR(32),
	outTradeNo				CHAR(64),
	sortCode				CHAR(13),
	dstStoreName			CHAR(50),
	sortingLineCode			CHAR(5),
	earlyFlightEnabled		INT,
	packEnabled				INT,
	upcountryCharge			INT,
	notice					TEXT,
	created_date			DATETIME
);

CREATE TABLE ordersModify(
	id						INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	mchId					CHAR(32),
	nonceStr				CHAR(32),
	signStr					CHAR(64),
	pno						CHAR(20),
	outTradeNo				CHAR(64),
	expressCatgory			INT,
	warehouseNo				CHAR(32),
	srcName					CHAR(50),
	srcPhone				CHAR(20),
	srcProvinceName			CHAR(150),
	srcCityName				CHAR(150),
	srcDistrictName			CHAR(150),
	srcPostalCode			CHAR(20),
	srcDetailAddress		CHAR(200),
	dstName					CHAR(50),
	dstPhone				CHAR(20),
	dstProvinceName			CHAR(150),
	dstCityName				CHAR(150),
	dstDistrictName			CHAR(150),
	dstPostalCode			CHAR(20),
	dstDetailAddress		CHAR(200),
	articleCategory			INT,
	weight					INT,
	width					INT,
	length					INT,
	height					INT,
	insured					INT,
	insureDeclareValue		INT,
	freightInsureEnabled	INT,
	opdInsureEnabled		INT,
	codEnabled				INT,
	codAmount				INT,
	remark					CHAR(200),
	created_date			DATETIME
);

CREATE TABLE ordersCancel(
	id						INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	mchId					CHAR(32),
	nonceStr				CHAR(32),
	signStr					CHAR(64),
	pno						CHAR(20),
	created_date			DATETIME
);

CREATE TABLE ordersCancelResponse(
	id						INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	ordersCancelId			INT,
	remark					CHAR(200),
	created_date			DATETIME
);

CREATE TABLE ordersRoutes(
	id						INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	mchId					CHAR(32),
	nonceStr				CHAR(32),
	signStr					CHAR(64),
	pno						CHAR(20),
	created_date			DATETIME
);

-- pno 	string(20) 	Flash Express tracking number
-- origPno 	string(20) 	Flash Express original tracking number
-- returnedPno 	string(20) 	Returned parcel Waybill number/tracking number
-- customaryPno 	string(20) 	If a returned parcel,this describes its customary parcel number
-- state 	integer 	parcel state
-- stateText 	string(100) 	parcel state description
-- stateChangeAt 	integer 	parcel state update timestamp UTC
-- routes.routedAt 	integer 	route status timestamp in UTC
-- routes.routedAction 	string(29) 	route status action
-- routes.message 	string(500) 	route status message
-- routes.state 	integer 	route status parcel state

CREATE TABLE ordersRoutesResponse(
	id						INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    ordersRoutesId			INT,
	pno					    CHAR(20),
    origPno					CHAR(20),
    customaryPno			CHAR(20),
	state					INT,
	stateText				CHAR(100),
	stateChangeAt			INT,
	routesRoutedAt			INT,
	routesRoutedAction		CHAR(29),
	routesMessage			TEXT,
	routesState				INT,
	created_date			DATETIME
);

-- mchId 	string(32) 	true 	merchant No.
-- nonceStr 	string(32) 	true 	random nonce string
-- sign 	string(64) 	true 	signature
-- date 	string(10) 	true 	notifying date.format:YYYY-MM-DD

CREATE TABLE notifications(
	id				INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	mchId			CHAR(32),
	nonceStr		CHAR(32),
	signStr			CHAR(64),
	dateStr			CHAR(10),
	created_date	DATETIME
);

-- ticketPickupId 	integer 	Flash Express notification id
-- kaName 	string(50) 	merchant name
-- srcName 	string(50) 	contact name of picking up address
-- phone 	string(20) 	contact phone number of picking up address
-- srcProvinceName 	string(150) 	province name of picking up address. (first-level administrative division)
-- srcCityName 	string(150) 	city name of picking up address. (Second-level administrative division)
-- srcDistrictName 	string(150) 	district name of picking up address. (Third-level administrative division)
-- srcDetailAddress 	string(200) 	detail address of picking up address
-- postalCode 	string(20) 	postal code of picking up address
-- kaWarehouseNo 	string(32) 	warehouse No. of picking up address.
-- kaWarehouseName 	string(32) 	warehouse name of picking up address.
-- staffInfoName 	string(50) 	courier name to picking up parcels
-- staffInfomobile 	string(20) 	courier phone number to picking up parcels
-- state 	integer 	Notification State
-- stateText 	string(100) 	state description of notification
-- estimateParcelNumber 	integer 	estimating parcels count to pick up
-- parcelNumber 	integer 	actually picked up parcels count
-- remark 	string(200) 	remark
-- createdAt 	integer 	notifying timestamp in UTC

CREATE TABLE notificationsResponse(
	id						INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	notificationsId			INT,
	ticketPickupId			INT,
	kaName					CHAR(50),
	srcName					CHAR(50),
	phone					CHAR(20),
	srcProvinceName 		CHAR(150),
	srcCityName				CHAR(150),
	srcDistrictName			CHAR(150),
	srcDetailAddress 		CHAR(200),
	postalCode				CHAR(20),
	kaWarehouseNo			CHAR(32),
	kaWarehouseName 		CHAR(32),
	staffInfoName			CHAR(50),
	staffInfomobile 		CHAR(20),
	state 					INT,
	stateText				CHAR(100),
	estimateParcelNumber 	INT,
	parcelNumber			INT,
	remark					CHAR(200),
	createdAt				INT,
	created_date			DATETIME
);

-- mchId 	string(32) 	true 	merchant No.
-- nonceStr 	string(32) 	true 	random nonce string
-- sign 	string(64) 	true 	signature
-- warehouseNo 	string(32) 	false 	warehouse No. of picking up address. It must be the merchant warehouse number queried through the interface getAllWarehouses.
-- srcName 	string(50) 	true 	contact name of picking up address
-- srcPhone 	string(20) 	true 	contact phone number of picking up address
-- srcProvinceName 	string(150) 	true 	province name of picking up address. (first-level administrative division)
-- srcCityName 	string(150) 	true 	city name of picking up address. (Second-level administrative division)
-- srcDistrictName 	string(150) 	false 	district name of picking up address. (Third-level administrative division)
-- srcPostalCode 	string(20) 	true 	postal code of picking up address
-- srcDetailAddress 	string(200) 	true 	detail address of picking up address
-- estimateParcelNumber 	integer 	true 	estimating parcels count to pick up
-- remark 	string(200) 	false 	remark

CREATE TABLE notify(
	id						INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	mchId					CHAR(32),
	nonceStr				CHAR(32),
	signStr					CHAR(64),
	warehouseNo 			CHAR(32),
	srcName					CHAR(50),
	srcPhone				CHAR(20),
	srcProvinceName 		CHAR(150),
	srcCityName				CHAR(150),
	srcDistrictName			CHAR(150),
	srcPostalCode			CHAR(20),
	srcDetailAddress		CHAR(200),
	estimateParcelNumber	INT,
	remark					CHAR(200),
	created_date			DATETIME
);

-- ticketPickupId 	string(20) 	Flash Express pick up ticket id
-- staffInfoId 	integer 	Courier ID
-- staffInfoName 	string(50) 	Courier's name
-- staffInfoPhone 	string(20) 	Courier telephone number
-- upCountryNote 	string(200) 	Tips for remote areas
-- timeoutAtText 	string(100) 	Timeout range
-- ticketMessage 	string(200) 	Tips of Timeout
-- notice 	string(255) 	notice

CREATE TABLE notifyResponse(
	id					INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	notifyId			INT,
	ticketPickupId		CHAR(20),
	staffInfoId 		INT,
	staffInfoName 		CHAR(50),
	staffInfoPhone		CHAR(20),
	upCountryNote 		CHAR(200),
	timeoutAtText 		CHAR(100),
	ticketMessage 		CHAR(200),
	notice 				CHAR(255),
	created_date		DATETIME
);

CREATE TABLE notifyTracking(
	id					INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	ordersId			INT,
	pno					CHAR(20),
	ticketPickupId		CHAR(20),
	remark				CHAR(200),
	created_date		DATETIME
);

-- mchId 	string(32) 	true 	merchant No.
-- nonceStr 	string(32) 	true 	random nonce string
-- sign 	string(64) 	true 	signature

CREATE TABLE notifyCancel(
	id					INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	ticketPickupId		INT,
	mchId				CHAR(32),
	nonceStr			CHAR(32),
	signStr				CHAR(64),
	created_date		DATETIME
);

CREATE TABLE notifyCancelResponse(
	id					INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	notifyCancelId		INT,
	remark				CHAR(200),
	created_date		DATETIME
);
