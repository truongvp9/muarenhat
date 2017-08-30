/*********************/

var arrowimages={down:['downarrowclass', 'skins/images/down.png', 20], right:['rightarrowclass', 'skins/images/right.gif']}

var jqueryslidemenu={

animateduration: {over: 200, out: 100}, //duration of slide in/ out animation, in milliseconds

buildmenu:function(menuid, arrowsvar){
	jQuery(document).ready(function($){
		var $mainmenu=$("#"+menuid+">ul")
		var $headers=$mainmenu.find("ul").parent()
		$headers.each(function(i){
			var $curobj=$(this)
			var $subul=$(this).find('ul:eq(0)')
			this._dimensions={w:this.offsetWidth, h:this.offsetHeight, subulw:$subul.outerWidth(), subulh:$subul.outerHeight()}
			this.istopheader=$curobj.parents("ul").length==1? true : false
			$subul.css({top:this.istopheader? this._dimensions.h+"px" : 0})
			$curobj.children("a:eq(0)").css(this.istopheader? {paddingRight: arrowsvar.down[2]} : {}).append(
				'<img src="'+ (this.istopheader? arrowsvar.down[1] : arrowsvar.right[1])
				+'" class="' + (this.istopheader? arrowsvar.down[0] : arrowsvar.right[0])
				+ '" style="border:0;" />'
			)
			$curobj.hover(
				function(e){
					var $targetul=$(this).children("ul:eq(0)")
					this._offsets={left:$(this).offset().left, top:$(this).offset().top}
					var menuleft=this.istopheader? 0 : this._dimensions.w
					menuleft=(this._offsets.left+menuleft+this._dimensions.subulw>$(window).width())? (this.istopheader? -this._dimensions.subulw+this._dimensions.w : -this._dimensions.w) : menuleft
					if ($targetul.queue().length<=1) //if 1 or less queued animations
						$targetul.css({left:menuleft+"px", width:this._dimensions.subulw+'px'}).slideDown(jqueryslidemenu.animateduration.over)
				},
				function(e){
					var $targetul=$(this).children("ul:eq(0)")
					$targetul.slideUp(jqueryslidemenu.animateduration.out)
				}
			) //end hover
			$curobj.click(function(){
				$(this).children("ul:eq(0)").hide()
			})
		}) //end $headers.each()
		$mainmenu.find("ul").css({display:'none', visibility:'visible'})
	}) //end document.ready
}
}

//build menu with ID="myslidemenu" on page:
jqueryslidemenu.buildmenu("myslidemenu", arrowimages)



function tang()
{	    
	if(document.getElementById("fontnewsdetail").style.fontSize=="")
	{
	   document.getElementById("fontnewsdetail").style.fontSize="10pt";
	}
	var vfont = document.getElementById("fontnewsdetail").style.fontSize;
	var new_size = (Number(String(vfont).substring(0,vfont.length-2)) + 1);
	if(new_size>18) new_size=18;
	document.getElementById("fontnewsdetail").style.fontSize= new_size + "pt";
	TangCon(document.getElementById("fontnewsdetail").style.fontSize);
}
	
function TangCon(size)
{
    var cha = document.getElementById("fontnewsdetail");
    
    var listcon ;
    if (document.all)
        listcon = cha.all;
    else
        listcon = cha.getElementsByTagName("*");	        
    var len = listcon.length;
    for (var i = 0 ; i < len ; i++)
    {
        listcon[i].style.fontSize= size;        
    }
}
function giam()
{
    
	if(document.getElementById("fontnewsdetail").style.fontSize=="")
	{
	   document.getElementById("fontnewsdetail").style.fontSize="8pt";
	}
	else
	{
	    var vfont = document.getElementById("fontnewsdetail").style.fontSize;
	    var new_size = (Number(String(vfont).substring(0,vfont.length-2)) - 1);
	    if(new_size<6) new_size=6;
	     document.getElementById("fontnewsdetail").style.fontSize= new_size + "pt";
	}
	TangCon(document.getElementById("fontnewsdetail").style.fontSize);
}

/*eof vne*/