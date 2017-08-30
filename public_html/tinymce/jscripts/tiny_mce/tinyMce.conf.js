/**
 * Created by JetBrains PhpStorm.
 * User: ngannv
 * Date: 7/10/11
 * Time: 9:39 PM
 * To change this template use File | Settings | File Templates.
 */

tinyMCE.init({
             mode : "textareas",
        theme : "advanced",
			//invalid_elements : "script,abbr,acronym,address,applet,area,bdo,big,blockquote,button,caption,cite,code,col,colgroup,dd,del,dfn,iframe,ins,isindex,kbd,legend,map,menu,noscript,object,optgroup,option,param,textarea,var,ruby,samp,select,rtc",
    //invalid_elements : "@p[class]",

    valid_elements : "@[id|style|title|dir<ltr?rtl|lang|"+ "onmousedown|onmouseup|onmouseover|onmousemove|onmouseout|onkeypress|"
+ "onkeydown|onkeyup],a[rel|rev|charset|hreflang|tabindex|accesskey|type|"
+ "name|href|target|title|class|onfocus|onblur],strong/b,em/i,strike,u,"
+ "#p,-ol[type|compact],-ul[type|compact],-li,br,img[longdesc|usemap|"
+ "src|border|alt=|title|hspace|vspace|width|height|align],-sub,-sup,"
+ "-blockquote,-table[border=0|cellspacing|cellpadding|width|frame|rules|"
+ "height|align|summary|bgcolor|background|bordercolor],-tr[rowspan|width|"
+ "height|align|valign|bgcolor|background|bordercolor],tbody,thead,tfoot,"
+ "#td[colspan|rowspan|width|height|align|valign|bgcolor|background|bordercolor"
+ "|scope],#th[colspan|rowspan|width|height|align|valign|scope],caption,-div,"
+ "-span,-code,-pre,address,-h1,-h2,-h3,-h4,-h5,-h6,hr[size|noshade],-font[face"
+ "|size|color],dd,dl,dt,cite,abbr,acronym,del[datetime|cite],ins[datetime|cite],"
+ "object[classid|width|height|*],param[name|value|_value],embed[type|width"
+ "|height|src|*],script[src|type],map[name],area[shape|coords|href|alt|target],bdo,"
+ "button,col[align|char|charoff|span|valign|width],colgroup[align|char|charoff|span|"
+ "valign|width],dfn,fieldset,form[action|accept|accept-charset|enctype|method],"
+ "input[accept|alt|checked|disabled|maxlength|name|readonly|size|src|type|value],"
+ "kbd,label[for],legend,noscript,optgroup[label|disabled],option[disabled|label|selected|value],"
+ "q[cite],samp,select[disabled|multiple|name|size],small,"
+ "textarea[cols|rows|disabled|name|readonly],tt,var,big",


			height: "300px",
			plugins : "paste,inlinepopups",
			theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist",
            theme_advanced_buttons2:"",
            theme_advanced_buttons3:"",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_font_sizes : "3,4,5,6",
    
			theme_advanced_fonts : "Arial=arial;Verdana=verdana;Times New Roman=times new roman;Tahoma=tahoma",
			entity_encoding : "raw",			

			theme_advanced_buttons1_add : "fontselect,fontsizeselect,forecolor,backcolor,separator,link,unlink,pasteword,removeformat",
            //theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
           // theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",

			theme_advanced_path_location : "bottom",
			theme_advanced_path : false,
			theme_advanced_resize_horizontal : false,
			theme_advanced_resizing : true,
			forced_root_block : false,
			force_br_newlines : true,
			//force_p_newlines : true,
            apply_source_formatting : true
            

		});
