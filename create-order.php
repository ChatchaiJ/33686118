<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Project 33639001</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.20/css/uikit.css">
    <link rel="stylesheet" href="./jquery.Thailand.js/dist/jquery.Thailand.min.css">
</head>
<body>
    <div class="uk-container">
        <div id="loader">
            <div uk-spinner></div> รอสักครู่ กำลังโหลดฐานข้อมูล...
        </div>
        <form id="address" class="demo" style="display:none;" autocomplete="off" method="post" action="save-oder.php" uk-grid>
			<div class="uk-width-1-4">

<button class="uk-button uk-button-default" type="button">Flash Express</button>
<div uk-dropdown>
    <ul class="uk-nav uk-dropdown-nav">
        <li class="uk-active"><a href="#">Change</a></li>
    </ul>
</div>
			</div>
            <div class="uk-width-1-1">
                <h2>ผู้ส่ง</h2>
            </div>

            <div class="uk-width-1-2">
                <label>ชื่อผู้ส่ง</label>
                <input name="srcName" class="uk-input uk-width-1-1" type="text" required>
            </div>

            <div class="uk-width-1-2">
                <label>เบอร์โทร</label>
                <input name="srcPhone" class="uk-input uk-width-1-1" type="text" required>
            </div>

            <div class="uk-width-1-2">
                <label>ที่อยู่</label>
                <input name="srcDetailAddress" class="uk-input uk-width-1-1" type="text" required>
            </div>

            <div class="uk-width-1-2">
                <label>ตำบล / แขวง</label>
                <input name="srcDistrictName" class="uk-input uk-width-1-1" type="text" required>
            </div>

            <div class="uk-width-1-2">
                <label>อำเภอ / เขต</label>
                <input name="srcCityName" class="uk-input uk-width-1-1" type="text" required>
            </div>

            <div class="uk-width-1-2">
                <label>จังหวัด</label>
                <input name="srcProvinceName" class="uk-input uk-width-1-1" type="text" required>
            </div>

            <div class="uk-width-1-2">
                <label>รหัสไปรษณีย์</label>
                <input name="srcPostalCode" class="uk-input uk-width-1-1" type="text" required>
            </div>

            <div class="uk-width-1-1">
                <label><input name="srcSaveAddress"class="uk-checkbox" type="checkbox" checked>บันทึกที่อยู่ผู้ส่ง</label>
            </div>

            <div class="uk-width-1-1">
                <h2>ผู้รับ (ที่อยู่ในการจัดส่ง)</h2>
            </div>

            <div class="uk-width-1-2">
                <label>ชื่อผู้รับ</label>
                <input name="dstName" class="uk-input uk-width-1-1" type="text" required>
            </div>

            <div class="uk-width-1-2">
                <label>เบอร์โทร</label>
                <input name="dstPhone" class="uk-input uk-width-1-1" type="text" required>
            </div>

            <div class="uk-width-1-2">
                <label>ที่อยู่</label>
                <input name="dstDetailAddress" class="uk-input uk-width-1-1" type="text" required>
            </div>

            <div class="uk-width-1-2">
                <label>ตำบล / แขวง</label>
                <input name="dstDistrictName" class="uk-input uk-width-1-1" type="text" required>
            </div>

            <div class="uk-width-1-2">
                <label>อำเภอ / เขต</label>
                <input name="dstCityName" class="uk-input uk-width-1-1" type="text" required>
            </div>

            <div class="uk-width-1-2">
                <label>จังหวัด</label>
                <input name="dstProvinceName" class="uk-input uk-width-1-1" type="text" required>
            </div>

            <div class="uk-width-1-2">
                <label>รหัสไปรษณีย์</label>
                <input name="dstPostalCode" class="uk-input uk-width-1-1" type="text" required>
            </div>

            <div id="codAmountBox" class="uk-width-1-1" style="display:none;">
                <label>จำนวนเงิน (บาท)</label>
                <input name="codAmount" class="uk-input uk-width-1-1" type="text" value="0">
            </div>

            <div class="uk-width-1-1">
                <label><input name="dstSaveAddress"class="uk-checkbox" type="checkbox" checked>บันทึกที่อยู่ผู้รับ</label>
                <label><input id="codEnabled" name="codEnabled"class="uk-checkbox" type="checkbox">เก็บเงินปลายทาง (ถ้ามี)</label>
            </div>

            <div class="uk-width-1-1">
                <button class="uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom">บันทึกข้อมูล</button>
            </div>

    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js" 
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" 
            crossorigin="anonymous"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.20/js/uikit.min.js"></script>
    <!-- dependencies for zip mode -->
    <script type="text/javascript" src="./jquery.Thailand.js/dependencies/zip.js/zip.js"></script>
    <!-- / dependencies for zip mode -->
    <script type="text/javascript" src="./jquery.Thailand.js/dependencies/JQL.min.js"></script>
    <script type="text/javascript" src="./jquery.Thailand.js/dependencies/typeahead.bundle.js"></script>
    <script type="text/javascript" src="./jquery.Thailand.js/dist/jquery.Thailand.min.js"></script>

    <script type="text/javascript">
        $.Thailand({
            database: './jquery.Thailand.js/database/db.json', 

            $district: $('#address [name="dstDistrictName"]'),
            $amphoe: $('#address [name="dstCityName"]'),
            $province: $('#address [name="dstProvinceName"]'),
            $zipcode: $('#address [name="dstPostalCode"]'),

            onDataFill: function(data){
                console.info('Data Filled', data);
            },

            onLoad: function(){
                console.info('Autocomplete is ready!');
                $('#loader, .demo').toggle();
            }
        });

       // cash on delivery
        $('#codEnabled').change(function(){
            if ($('#codEnabled').is(":checked")) {
                 $('#codAmountBox').show();
            } else {
                 $('#codAmountBox').hide();
            }
         });

    </script>

</body>
</html>
