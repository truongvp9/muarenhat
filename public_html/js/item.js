

var pay_type = 1;
var type_otp = 0;

function fetch_object(idname){
	if (document.getElementById){
		return document.getElementById(idname);
	}
	else if (document.all){
		return document.all[idname];
	}
	else if (document.layers){
		return document.layers[idname];
	}
	else{
		return null;
	}
}

function RequestFrameCat(a){
	item_frame.location.href="request_frame.php?request_type=item_frame&idcat="+a;
}	


function edit_post(url,id){
	window.document.location = url + 'catid_edit=' + id;
}
function countUp(str){
	str = trim(str);
	
	var strNotAllow = "ABCDEFGHIJKLMNOPQRSTUVWXYZÁÀÃẠÂẤẦẪẬĂẮẰẴẶÉÈẼẸÊẾỀỄỆÍÌĨỊÓÒÕỌÔỐỒỖỘƠỚỜỠỢÚÙŨỤƯỨỪỮỰÝỲỸỴ";
	var aLen = str.length;
	
	var intCount = 0;
	for(i=0;i<aLen;i++) {
		strC = str.charAt(i);
		if (strNotAllow.indexOf(strC)!=-1)
			intCount++;
	}
	if(intCount>Math.floor(aLen/3)) {
		alert("Bạn nhập tiêu đề quá nhiều chữ HOA cho phép!");
		return false;
	}
	return true;
}
function tieude_press(e){
    if(e.keyCode==13 || e.which==13){
        return validate();
    }
}
function validate(type_otp){
	var f = document.itemForm;
	var checkspace = /^\s+/;
	var ad_title = trim(f.ad_title.value);
	
	var ad_description = tinyMCE.get('ad_description').getContent();
    document.getElementById('ad_description').value=ad_description;//fix lỗi thông báo "bạn cần nhập nội dung"
    
	if (ad_title == "" || ad_title == null) {
		alert( "Bạn chưa nhập tiêu đề!" );
		f.ad_title.focus();
		return (false);
	}
	if (ad_title.length < 5) {
		alert( "Tiêu đề phải lớn hơn 5 ký tự!" );
		f.ad_title.focus();
		return (false);
	}
	if (!countUp(f.ad_title.value)) {
		f.ad_title.focus();
		return (false);
	}
	if (f.ad_cat_id.value == 0) {
		alert( "Bạn chưa chọn chuyên mục!" );
		f.ad_cat_id.focus();
		return (false);
	}				
	if (f.ad_id_pcat.value == 0 && f.ad_id_pcat.disabled == false) {
		alert( "Bạn chưa chọn nhu cầu!" );
		f.ad_id_pcat.focus();
		return (false);
	}		
	
	if (f.ad_id_subcat.value == 0 && f.ad_id_subcat.disabled == false) {
		alert( "Bạn chưa chọn chủng loại!" );
		f.ad_id_subcat.focus();
		return (false);
	}	
	if (f.ad_city_id.value == -1) {
		alert( "Bạn chưa chọn tỉnh thành!" );
		f.ad_city_id.focus();
		return (false);
	}
	if(f.ad_cat_id.value != 83 && f.ad_cat_id.value != 100 && f.ad_cat_id.value != 266 && f.ad_cat_id.value != 278){
		if (f.ad_city_id.value == 0) {
			alert( "Bạn phải chọn tỉnh thành cho tin đăng!" );
			f.ad_city_id.focus();
			return (false);
		}
	}
	//	alert(f.ad_cat_id.value)
	if (f.ad_cat_id.value == 15 || f.ad_cat_id.value == 272) {
		if (f.ad_city_id.value == 0) {
			alert( "Bạn phải chọn tỉnh thành cho tin đăng!" );
			f.ad_city_id.focus();
			return (false);
		}
		//else if((f.ad_city_id.value != 0) && (f.ad_city_id.value != -1)) {
		else if((f.ad_city_id.value == 1) || (f.ad_city_id.value == 2) || (f.ad_city_id.value == 3) || (f.ad_city_id.value == 4) || (f.ad_city_id.value == 9) || (f.ad_city_id.value == 24)) {	
			if (f.ad_dist_id.value == 0) {
				alert( "Bạn phải chọn quận huyện!" );
				f.ad_dist_id.focus();
				return (false);
			}
		}
	}
	
	if (f.ad_description.value == "" || f.ad_description.value == null) {
		alert( "Bạn chưa nhập nội dung!" );
		f.ad_description.focus();
		return (false);
	}

	/*	validate chuyen muc dien thoai
	if (f.ad_cat_id.value == 2) {
		if(!IS_LOGIN){
			alert( "Bạn phải đăng nhập mới được đăng tin" );
			f.ad_cat_id.focus();
			return (false);
		}
	}*/
	if(!type_otp){
		if (typeof(f.validate_sign)!='undefined' && f.validate_sign.value == "") {
			alert( "Bạn chưa nhập vào mã an toàn!" );
			f.validate_sign.focus();
			return (false);
		}
	}
	return true;
}

function trim(str){
	if(!str || typeof str != 'string')
		return null;
	str = Loaidaucach(str);
	return str.replace(/^[\s]+/,'').replace(/[\s]+$/,'').replace(/[\s]{2,}/,'');
}

function Loaidaucach(ElementId){
	var strDes = ElementId;
	var strTag = strDes;

	var i=0;
	while (i<strDes.length){
		if(strTag.charAt(i)==' ' && strTag.charAt(i+1)==' ' && strTag.charAt(i+2)==' '){
			str1 = strTag.substring(0,i);
			str2 = strTag.substring(i+2,strTag.length);
			strTag = str1 + str2;
			//alert(strTag+'\n gia tri cua bien i:'+i);
			i = i;
		//	alert('gia tri xau Tag:'+strTag+'\ngia tri xau Des:'+strDes);
		}
		if(strTag.charAt(i)==' ' && strTag.charAt(i+1)==' '){
			str1 = strTag.substring(0,i);
			str2 = strTag.substring(i+1,strTag.length);
			strTag = str1 + str2;
			//alert(strTag+'\n gia tri cua bien i:'+i);
			i = i;
		//	alert('gia tri xau Tag:'+strTag+'\ngia tri xau Des:'+strDes);
		}
		else{i=i+1;}
		return strTag;
	}
}
//var catIdvalue = 0;
//var cityId = -1;
function GenSubCat(catIdvalue,subcat,type,hiddencat){   
	var objsubcatRows = document.getElementById(hiddencat)

   var subcatRows = objsubcatRows.value.split('$');

   var subcatname = (type=='1')?'ad_id_pcat':'ad_id_subcat';
   
   var subcatF = (type=='1')?'Chọn nhu cầu':'Chọn chủng loại';

   var objSubcat = document.getElementById(subcat);

   var opts = objSubcat.options.length;
   for(var j=opts - 1;j > 0;j--)
   {
   		objSubcat.removeChild(objSubcat.options[j]);
   }
   //alert(opts);
    if(catIdvalue != '0'){
	   for(var i=0;i < subcatRows.length;i++){

	   		var subcatRow = subcatRows[i];

	   		var row = subcatRow.split(';');

	        if(row[3] == catIdvalue && row[2] == type){
	       		var opt = document.createElement('OPTION');
	        	opt.value = row[0];
	         	if(navigator.appName.indexOf('Microsoft') !=-1)
	         		opt.innerText = row[1];
	         	else
		        	opt.text = row[1];
	        	objSubcat.appendChild(opt);
	        }

	   }

	   if(objSubcat.options.length <= 1 )
	   		objSubcat.disabled = 'disabled';
	   else
	       objSubcat.disabled = '';
   }
   else{
   	  objSubcat.disabled = 'disabled';
   }
   return true;
}

function SetSubcat(hidden, idCity, ad_id, cat_id){
	var objCat = document.getElementById("ad_cat_id");
    var cats = objCat.options.length;
    var catId = objCat.value;

    //Kiểm tra nếu chọn chuyên mục bds thì redirect sang bds.rongbay.com
    if(catId == 294){
    	var redic_url = "http://bds.rongbay.com/home.html?cmd=realestate&action=estateup";
    	window.open(redic_url,"_blank");
    	return
    }
	
    //Trường hợp update
    if (parseInt(cat_id) > 0)
    {
		catId = cat_id;
	}
	//Trường hợp update + onchange cate
	else if(isNaN(cat_id) == true)
	{
		catId = cat_id.value;
	}

    if(!ad_id || (ad_id && jQuery.inArray(catId, cate_otp)))
    {
	    //Nếu tồn tại mảng config gửi otp
	    if(cate_otp){
	    	for(i in cate_otp)
			{
				if((!ad_id && cate_otp[i] == catId) || (ad_id && cate_otp[i] == catId && show_item_wait == 2) || (ad_id && cate_otp[i] == catId && show_item_wait == 3) || (ad_id && cate_otp[i] == catId && show_box_otp == 2))
				{
					//jQuery("#box-button-add").css("display", "none");
					jQuery("#box-button-next").css("display", "block");
					jQuery("#box-thongbao").css("display", "block");
					break;
				}
				else{
					jQuery("#box-thongbao").css("display", "none");
					jQuery("#box-button-next").css("display", "none");
					//jQuery("#box-button-add").css("display", "block");
				}
			}
	    }
    }
    
	for(var i=0;i < cats; i++){
		if(objCat.options[i].selected){
			catIdvalue = objCat.options[i].value;
			break;
		}
	}
	
    GenSubCat(catIdvalue,'ad_id_pcat','1',hidden);
	GenSubCat(catIdvalue,'ad_id_subcat','0',hidden);
	
	//GenSubCity(idCity,catIdvalue);1234xxx
    
	//GenCity(idCity,catIdvalue);
    //ngannv fix bug hiển thị Tỉnh thành và Quận huyện không khớp nhau
    var IDCity=document.getElementById('ad_city_id').value;
	SetDistrcs(IDCity,catIdvalue,2);
   // alert(a);
	return true;
}

//add item to cart
function addToCart(){
	if(validate(1)){
		var itemForm = document.getElementById("itemForm");
		jQuery("#ad_to_cart").attr("value", 1);
		itemForm.submit();
	}
	/*var data= "packId="+pack+"&item_id="+item_id+"&item_choice="+item_choice;
	jQuery.ajax({
	    type: "POST",
	    url:"ajax_request.php?request_type=payment&act=getItemCart",
	    data: data,
	    dataType: 'json',
	    success: function(json)
	    {
	    	num_item_cart = json.num_item_cart;
	    	jQuery('#num_item_cart').attr('innerHTML', "<b>Có "+num_item_cart+" tin</b>");
	    	shop.cart.viewListItemCart();
	    	jQuery('#listItemChoiceCart').attr('innerHTML', json.templates);
	    }
	});
	return false;*/
}

/*function GenCity(idCity,catIdvalue){   
	var objcityRows = document.getElementById('resCity')
	var subcatRows = objcityRows.value.split('$');
	var cityopt = 'Chọn nơi rao';
	
	var objcity = document.getElementById('ad_city_id');
	
	var opts = objcity.options.length;
	for(var j=opts - 1;j > 0;j--){
		objcity.removeChild(objcity.options[j]);
	}
	
	for(var i=0;i < subcatRows.length;i++){
		var subcatRow = subcatRows[i];
		var row = subcatRow.split(';');
		if(catIdvalue != 100 && catIdvalue != 278 && catIdvalue != 266 && catIdvalue != 83){
			if(row[0] != 0){
				var opt = document.createElement('OPTION');
				opt.value = row[0];
				if(navigator.appName.indexOf('Microsoft') !=-1)
					opt.innerText = row[1];
				else
					opt.text = row[1];
				objcity.appendChild(opt);
			}
		}
		else{
			var opt = document.createElement('OPTION');
			opt.value = row[0];
			if(typeof(row[1])!="undefined"){
				if(navigator.appName.indexOf('Microsoft') !=-1)
					opt.innerText = row[1];
				else
					opt.text = row[1];
				objcity.appendChild(opt);
			}
		}
	}
	return true;
}*/

function SetDistrcs(e, cateId,type){
	if(type==1)
		cityId = e.value;
	else
		cityId = e;

	if(flgScreen==1){
		cateId = catIdvalue;
	}
	else{
		if(catIdvalue >0 && cateId != catIdvalue)
			cateId = catIdvalue;
	}
	GenSubCity(cityId,cateId);
}

function GenSubCity(cityId,catIdvalue){   
	var objsubcityRows = document.getElementById('subcity')
    var subcatRows = objsubcityRows.value.split('$');
	var subcityopt = 'Chọn quận huyện';
	
	var objSubcity = document.getElementById('ad_dist_id');
	
	var opts = objSubcity.options.length;
	for(var j=opts - 1;j > 0;j--){
		objSubcity.removeChild(objSubcity.options[j]);
	}

	if(catIdvalue == 15 || catIdvalue == 272){
	   for(var i=0;i < subcatRows.length;i++){
	   		var subcatRow = subcatRows[i];
	   		var row = subcatRow.split(';');
	        if(row[2] == cityId){
	       		var opt = document.createElement('OPTION');
	        	opt.value = row[0];
	         	if(navigator.appName.indexOf('Microsoft') !=-1)
	         		opt.innerText = row[1];
	         	else
		        	opt.text = row[1];
	        	objSubcity.appendChild(opt);
	        }
	   }

	   if(objSubcity.options.length <= 1 ){
	   		objSubcity.disabled = 'disabled';
	   }else{
	       objSubcity.disabled = '';
	   }
   }
   else{
   	   objSubcity.disabled = 'disabled';
   }
   return true;
}

/*function PutCity(cityId,catIdvalue){
	GenCity(cityId,catIdvalue);
	var SubName = 'ad_city_id';
	PutCat(cityId,SubName);
}*/

function PutSubCity(cityId,catIdvalue,distId){
	GenSubCity(cityId,catIdvalue);
	var SubName = 'ad_dist_id';
	PutCat(distId,SubName);
}

function PutSubCat(catidvalue,subcatid,subcatvalue,order,hidden){
	GenSubCat(catidvalue,subcatid,order,hidden);
	var SubName = (order=='1')?'ad_id_pcat':'ad_id_subcat';
	PutCat(subcatvalue,SubName);
}

function PutCat(catidvalue,catName){
	var objSub = document.getElementById(catName);
	var cats = objSub.options.length;
	for(var i=0;i < cats; i++){
		if(objSub.options[i].value == catidvalue){
			objSub.options[i].selected = true;
			break;
		}
	}	
}

function onChangeNeeds(e){
	var needsId = e.value;
	if(needsId != 494)//neu chon phong khach san
		return;
}

// add by Namdg
function do_check_vip(objVip, objClick){
	var obVip = document.getElementById(objVip);
	var obClick = document.getElementById(objClick);
	
	if (obVip.checked == true)
		obClick.disabled = false;
	else{
		obClick.disabled = true;
	}
}
function mce_img_embed(img_url){
	var tmp_image = new Image(); 
	tmp_image.src = img_url;
	
	if(tmp_image.width > 0){
		tinyMCE.execCommand('mceInsertContent', false, '<br /><img src="'+img_url+'" '+(tmp_image.width > 700 ? 'width="700"':'')+' /> <br /><br />');
	}
	else{
		tinyMCE.execCommand('mceInsertContent', false, '<br /><img src="'+img_url+'" /> <br /><br />');	
	}
	delete(tmp_image);
}
/**
* @comment : insert_img(url)-->Chức năng tương tự hàm mce_img_embeb sử dụng cho mục đăng tin sử dụng InnovaEditor
* @author : ngankt2
* @param limg_url="đường dẫn hình"
* @return bool;
* */
function insert_img(img_url){
    var oEditor=parent.oUtil.oEditor;
    var img=new Image();
    img.src=img_url;
    var w="700px";
    if(img.width<=700){
        w=img.width+"px";
    }
    var imgHtml='<img src="'+img_url+'" style="width:'+w+';"/><br/>';
    oEditor.document.execCommand("insertHTML",false,imgHtml);
    delete(img);self.close();
    return false;
}
function check_file_ext( fileName, fileTypes ){
	if (!fileName) return false;
	dots = fileName.split(".");fileType = dots[dots.length-1];
    //alert( fileType);
	for(var i=0;i<fileTypes.length;i++){
        if(fileType.toLowerCase() == fileTypes[i].toLowerCase()){
            return true;
        }
    }//end for
	return false;
}

function showRequest(formData, jqForm, options){
	var fileToUploadValue = jQuery('input[@id=photo]').fieldValue();
	
	if (fileToUploadValue[0]){
		var	fileTypes=['jpg','jpeg','gif','png'];
		
		var fileName = fileToUploadValue.toString();
		
		if(check_file_ext(fileName,fileTypes)){
			jQuery("#photo").hide();
			jQuery('#loading').show();			
			return true;
		}

		else{	
			jQuery("#photo").css("backgroundColor","yellow");
			jQuery("#upload_form").reset();
			alert('Chỉ cho phép định dạnh file '+fileTypes);
			jQuery("#photo").focus();
		}

	}
	else{
		
		alert('Bạn chưa chọn Ảnh để upload!');
	}
	
	return false;
}
function showResponse(data, statusText){
	jQuery('#loading').hide();
	if (statusText == 'success') {
		if(data.error!='success'){//Ko up được ảnh
			jQuery("#upload_form").reset();
			jQuery("#photo").css("backgroundColor","yellow");
			
			if(data.error=='not_login'){
				alert('Bạn chưa đăng nhập, hãy đăng nhập lại hệ thống trước khi sử dụng chức năng này!');
			}
			else if(data.error=='not_perm'){
				alert('Bạn không phải người đăng tin nên không thực hiện được chức năng này, ấn F5 để load lại trang!');
			}
			else if(data.error=='not_exit'){
				alert('Tin rao không tồn tại, ấn F5 để load lại trang!');
			}
			else if(data.error=='over_max_size'){
				alert('Ảnh quá dung lượng cho phép!');
			}
			else if(data.error=='limit'){
				alert('Bạn up quá số ảnh cho phép!');
			}
			else if(data.error=='ext_invalid'){
				alert('Ảnh bạn chọn không đúng định dạng!');
			}
			else if(data.error=='not_uploaded'){
				alert('Không Upload được file!');
			}
		}
		else{//Upload thành công!
			//data.image_url;
			jQuery("#upload_form").reset();
			jQuery("#photo").css("backgroundColor","#FFFFFF");
			jQuery("#image_list_header").show();
			
			jQuery("#image_list").prepend('<div id="img_div'+data.id+'" style="float:left;padding:8px 10px; margin:6px 0 3px 15px;border:#ccc 1px solid;_width:115px;background-color:#fff">\
										<div  style="background:url('+data.image_thumb+') no-repeat center;height:80px;"><a href="'+data.image_max+'" rel="thumbnail" onclick="return false"><img title="Xem ảnh gốc" src="style/images/spacer.gif" height="80" border="0"></a>\
                                           </div>\
                                       <center>\
                                             <a href="javascript:void(0);" onclick="mce_img_embed(\''+data.image_max+'\');return false" class="gallery" title="Chèn ảnh này vào trong nội dung!" style="color:#288FB8;text-decoration:none"><strong>Chèn ảnh</strong></a> | <a href="#" onclick="return del_image('+data.id+');" class="gallery" title="Xóa ảnh này!" style="color:#C00;text-decoration:none"><strong>Xóa</strong></a>\
                                       </center>\
                                     </div>');
			
			
			
			//mce_img_embed(data.image_max);
			
			thumbnailviewer.init();
			if(count_img <=0){
				jQuery("#image_list_header").show();
				jQuery("#image_list").show()
				jQuery("#post_form").css("height","182px");
				count_img = 1;				
			}
			else{	
				count_img++;
			}
			jQuery("#img_num").html(count_img);
		}
	} 
	else{
		alert('Không up được ảnh!');
	}
	jQuery("#photo").show();
}


function del_image(img_id){
	if(confirm("Bạn có chắc chắn muốn xóa không?")){
		jQuery.getJSON(WEB_DIR+"ajax_request.php?request_type=del_img",{img_id:img_id},function(data){
			if(data.error!='success'){//Ko xóa được ảnh
				jQuery("#upload_form").reset();
				jQuery("#photo").css("backgroundColor","yellow");
				
				if(data.error=='not_login'){
					alert('Bạn chưa đăng nhập, hãy đăng nhập lại hệ thống trước khi sử dụng chức năng này!');
				}
				else if(data.error=='not_perm'){
					alert('Bạn không được thực hiện được chức năng này, ấn F5 để load lại trang!');
				}
				else if(data.error=='item_not_exit'){
					alert('Tin rao không tồn tại, ấn F5 để load lại trang!');
				}
				else if(data.error=='not_exit'){
					alert('Ảnh không tồn tại, ấn F5 để load lại trang!');
				}
			}
			else{
				jQuery("#img_div"+img_id).hide();
				count_img--;
				
				if(count_img <=0){
					count_img = 0;
					jQuery("#image_list_header").hide();
					jQuery("#image_list").hide();
					jQuery("#post_form").css("height","");	
				}
				
				jQuery("#img_num").html(count_img);
			}
		});
	}
	return false;
}

function stop_upload(){
	jQuery("#upload_form").reset();
	jQuery("#photo").css("backgroundColor","#FFFFFF");
	jQuery("#loading").hide();
	jQuery("#photo").show();
}

function addNextOtp(){
	pay_type = 1;
	if(validate(1)){
		shop.show_overlay_popup('payment-add-item', 'Xác thực cho tin đăng',
		template.choosePaymentTypes('payment-add-item', 'Xác thực cho tin đăng'),
		{
			background: {
				'background-color' : 'transparent'
			},
			border: {
				'background-color' : 'transparent',
				'padding' : '0px'
			},
			title: {
				'display' : 'none'
			},
			content: {
				'padding' : '0px',
				'width' : '625px',
				'font-size': '12px'
			}
		});
        if(isIE6()==true){
            de_active_sel();
            jQuery('#huy_btn').click(function(){
                //alert("msg");
                reset_control();
            });
            jQuery('a.classic-popup-close').click(function(){
                reset_control();
            });

        }//end if

	}
	jQuery('.box-gradien').slideUp().addClass('hidden');
	jQuery("#pay_input_card").css("display", "none");
	jQuery("#pay_info_sms").css("display", "block");
}


function requestSentOtp(){
	var resent_mobi = jQuery("#resent_mobi").attr("value");
	if(!resent_mobi)
	{
		alert("Hãy nhập số điện thoại");
		return
	}
	
	var data= "resent_mobi="+resent_mobi;
	
	jQuery.ajax({
	    type: "POST",
	    url:"ajax_request.php?request_type=payment&act=getOtpByTel",
	    data: data,
	    dataType: 'json',
	    success: function(json)
	    {
	    	if(json.errors == "")
	    	{
		    	jQuery('#otp_code').attr('value', json.otp);
		    	jQuery('.rule_sms').slideUp().addClass('hidden');
	    	}
	    	else
	    	{
	    		alert(json.errors);
	    	}
	    }
	});
	return false;
}

function showConfirmOtp(popUpContent)
{
	var maxH = document.documentElement.clientHeight;
	
	if(maxH >=1024)
	{
		maxH = 188;
	}
	else{
		maxH = 66;
	}
	
	jQuery.blockUI({message: popUpContent ,
		overlayCSS: {
			opacity: 0.2,
			background:'#000000',
			algin:'center'
		},
		css: {
			position: 'absolute',
			border: 'none',
			width:'100%',
			top:maxH + 'px',
			left:0,
			backgroundColor: 'transparent'
	}});
}

function addItem(){
	//check choice payment type
	if(!pay_type)
	{
		alert("Hãy chọn hình thức thanh toán");
		return;
	}
	
	var itemForm = document.getElementById("itemForm");
	
	//Thanh toán bằng gửi sms
	if(pay_type == 1)
	{
		var otp_code = jQuery("#otp_code").attr("value");
		if(otp_code == "")
		{
			alert("Hãy nhập Mã xác thực");
			return
		}
		
		jQuery("#otp").attr("value", otp_code);
	}
	//Thanh toán bằng thẻ cào
	else
	{
		var card_type = 'mobifone';
		if (jQuery('#r_vinaphone').attr('checked') == true)
		{	
			card_type = 'vinaphone';
		}
		
		var card_code = jQuery("#card_code_info").attr("value");
		var mobi = jQuery("#mobi").attr("value");
		var email = jQuery("#email").attr("value");
		if(card_code == "")
		{
			alert("Hãy nhập mã số thẻ cào");
			return
		}
		if(mobi == "")
		{
			alert("Hãy nhập số điện thoại");
			return
		}
		if(email == "")
		{
			alert("Hãy nhập Email");
			return
		}
		
		jQuery("#card_code").attr("value", card_code);
		jQuery("#card_type").attr("value", card_type);
		jQuery("#mobi_user").attr("value", mobi);
		jQuery("#email_user").attr("value", email);
	}
	var strBtn = ('<a class="blueButton"><span><span>ĐĂNG TIN</span></span></a>');
	jQuery('#add_item_finish').attr('innerHTML', strBtn);
	jQuery("#pay_add").attr("value", pay_type);
	jQuery('#loading_pay').show();
	//window.document.itemForm.submit();
	itemForm.submit();

}

//Hàm thu gọn, mở rộng các hình thức thanh toán
function check_pay_type(type)
{
	pay_type = type;
	if(type == 1)
	{
		jQuery('.box-gradien').slideUp().addClass('hidden');
		jQuery("#pay_input_card").css("display", "none");
		jQuery("#pay_info_sms").css("display", "block");
	} 
	else
	{
		jQuery('.box-gradien').slideDown().removeClass('hidden');
		jQuery("#pay_info_sms").css("display", "none");
		jQuery("#pay_input_card").css("display", "block");
	}
} 

function viewMoreCardInfo()
{
	if(jQuery('.box-gradien').hasClass('hidden'))
	{
		jQuery('.box-gradien').slideDown().removeClass('hidden');
	}
	else
	{
		jQuery('.box-gradien').slideUp().addClass('hidden');
	}
}

function chooseTelco(obj, type){
	jQuery('#r_'+type).attr('checked', 'checked');
}

function close_frm_pay(){
    jQuery.unblockUI();
}

var template = {
    choosePaymentTypes : function(id, title){

    	var cardInfo = '';
	
		for(i in pay_card_info)
		{
			cardInfo += ('<tr><td valign="top" align="center" class="item bRight">'+ number_format(i) +' VNĐ</td><td valign="top" align="left" class="item bRight">Tin này được đăng và <a href="http://blog.rongbay.com/2011/03/08/t%E1%BB%B1-d%E1%BB%99ng-dang-l%E1%BA%A1i-tin/" target="_blank">tự động đăng lại</a> <b>' +pay_card_info[i]+ ' lần</b></td></tr>');
		} 
		 
        frmPay = join
            ('<div id="atm_online" style="margin-left:15px;margin-top:-5px">')
            	('<div class="blockCheckOut" style="margin-right: 0pt;">')
            		('<div class="paymentSelect fixPng"></div>')
            		('<div class="checkOutBox">')
            			('<div class="paymentCheckOut floatLeft">')
            				('<div class="sendSms fixPng"></div>')
            			('</div>')
            			('<div class="paymentContent floatLeft" style="width:485px">')
            				('<div class="infoInputLeft" style="width:100%;color:#777;font-size:11px">Dùng điện thoại di động soạn tin:</div>')
            				('<div class="infoInputLeft" style="width:100%;font-size:14px;padding-top:5px;text-indent:40px;padding-bottom:3px"><b>RBO</b> <font style="font-size:12px;color:#777">gửi</font> <b>8701</b> (<b>15.000đ/tin</b>) <font style="font-size:12px;color:#777">để tin này được đăng và <a href="http://blog.rongbay.com/2011/03/08/t%E1%BB%B1-d%E1%BB%99ng-dang-l%E1%BA%A1i-tin/" target="_blank">tự động đăng lại</a> <b>15 lần</b></font></div>')
            				('<div class="infoInputLeft" style="width:100%;text-align:left;color:#ff0000"><b>Hoặc</b></div>')
                        	('<div class="infoInputLeft" style="width:100%;font-size:14px;text-align:left;text-indent:40px;padding-top:8px;padding-bottom:5px"><b>RBO</b> <font style="font-size:12px;color:#777">gửi</font> <b>8001</b> (<b>500đ/tin</b>) <font style="font-size:12px;color:#777">để tin này được đăng</font></div>')
                        	('<div id="pay_info_sms" style="display: none;">')
                            	('<div class="infoInputLeft" style="width:100%;padding-top:3px;color:#777;font-size:11px">')
                            		('- Mã xác thực sẽ được gửi vào điện thoại của Quý khách, Quý khách vui lòng nhập vào ô bên dưới để tiếp tục thực hiện đăng tin.')
                                ('</div>')
                                
                        		('<div class="infoInputLeft" style="width:100%;padding-top:3px;color:#777;font-size:11px">')
                            		('- Sau khi gửi tin nhắn nếu không nhận được mã xác thực do lỗi nhà mạng, Quý khách vui lòng chờ hệ thống xử lý.')
                                ('</div>')
                                ('<div class="infoInputLeft" style="width:100%;padding-top:3px;color:#777;font-size:11px">')
                                	('- Một mã xác thực chỉ được dùng cho 1 lần đăng tin')
                                ('</div>')
                            	('<div style="float:left;padding-top:20px">')
                                    ('<div class="newLabel" style="float:left;font-size:12px">Mã xác thực:</div>')
                                    ('<div class="infoInputTxt" style="float:left;width:70px; margin-top:-5px;margin-left:10px">')
                                        ('<input type="text" name="otp_code" id="otp_code" class="txt" style="width:80%;font-size:14" onkeypress="return numberOnly(this,event);" maxlength="4"/>')
                                    ('</div>')
                                ('</div>')
                                
                                ('<div class="infoInputLeft" style="width:100%;padding-top:3px;color:#777;font-size:11px">')
						 			('- Nếu Quý khách đã gửi tin nhắn nhưng chưa nhận được mã xác thực thì click <a href="javascript:void(0)" onClick="shop.cart.viewMoreSmsInfo(this)"><b>Vào đây</b></a>')
								 	('<div class="rule_sms hidden">')
								 		('<div align="left" id="pay" style="display:inline ;width:100%">')
								 			('<div>')
												('<center style="width:460px;color:#000000;margin:5px auto 10px;padding:10px;background:#FFF9D7;border:1px solid #E2C822;font-size: 12px;">Quý khách nhập số điện thoại vừa nhắn tin vào ô bên dưới, chọn GỬI đi. Hệ thống sẽ tự động gửi lại mã xác thực cho Quý khách.</center>')
												('<div class="mTop5" id="msg_cart"></div>')
											('</div>')
								 		
											('<div id="pTop10" class="newCustomerInfo mTop5">')
												('<div class="input fl" style="width:115px">Số điện thoại: </div>')
												('<div class="fl">')
													('<input type="text" id="resent_mobi" name="resent_mobi" style="width:210px" value="" onkeypress="return shop.numberOnly(this, event);"/>')
													('&nbsp;<a href="javascript:void(0)" onclick="requestSentOtp()" id="fr" class="blueButton"><img src="style/images/payment/request_otp.png" /></a>')
												('</div>')
												('<div class="c"></div>')
											('</div>')
										('</div>')
								 	('</div>')
								('</div>')
                                
                            ('</div>')
            			('</div>')
            			('<div class="clear"></div>')
            		('</div>')
            	('</div>')
            ('</div>')
            ('<div style="clear:both;height:0;overflow:hidden"></div>')();
            
            return shop.popupSite(id, title, shop.join
			('<div class="content cartMoreAddress" style="padding:10px 15px">')
			('<form name="cartAddressForm" id="cartAddressForm">')
				(frmPay+'<div style="margin-top:15px" class="fl">')
                    ('<a class="blueButton" id="huy_btn" href="javascript:void(0)"  onclick="shop.hide_overlay_popup(\'payment-add-item\')"><span><span>HỦY BỎ</span></span></a>')
                    ('<div style="display:none;text-align:center;margin-top:9px;margin-left:175px" id="loading_pay" class="fl">')
						('<img src="style/images/uploading.gif" align="absmiddle"/> Đang xử lý... ')
					('</div>')
                ('</div>')
                ('<div style="margin-top:15px" class="fr" id="add_item_finish">')
                    ('<a class="blueButton" style="cursor:pointer" onclick="return addItem();"><span><span>ĐĂNG TIN</span></span></a>')
                ('</div>')
                ('<div class="c"></div>')
			('</form>')
		('</div>')());
    }
};
