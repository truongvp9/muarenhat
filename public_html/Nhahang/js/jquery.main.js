	/**
 * jQuery Plugin: "bgiframe"
 * Copyright (c) 2010 Brandon Aaron (http://brandonaaron.net)
 * Licensed under the MIT License
 *
 * Version 2.1.2
 */


/**
 * jQuery Plugin: "hoverIntent"
 * Copyright http://cherne.net/brian/resources/jquery.hoverIntent.html
 *
 * Version 6
 */
(function($){$.fn.hoverIntent=function(f,g){var cfg={sensitivity:7,interval:100,timeout:0};cfg=$.extend(cfg,g?{over:f,out:g}:f);var cX,cY,pX,pY;var track=function(ev){cX=ev.pageX;cY=ev.pageY};var compare=function(ev,ob){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);if((Math.abs(pX-cX)+Math.abs(pY-cY))<cfg.sensitivity){$(ob).unbind("mousemove",track);ob.hoverIntent_s=1;return cfg.over.apply(ob,[ev])}else{pX=cX;pY=cY;ob.hoverIntent_t=setTimeout(function(){compare(ev,ob)},cfg.interval)}};var delay=function(ev,ob){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);ob.hoverIntent_s=0;return cfg.out.apply(ob,[ev])};var handleHover=function(e){var ev=jQuery.extend({},e);var ob=this;if(ob.hoverIntent_t){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t)}if(e.type=="mouseenter"){pX=ev.pageX;pY=ev.pageY;$(ob).bind("mousemove",track);if(ob.hoverIntent_s!=1){ob.hoverIntent_t=setTimeout(function(){compare(ev,ob)},cfg.interval)}}else{$(ob).unbind("mousemove",track);if(ob.hoverIntent_s==1){ob.hoverIntent_t=setTimeout(function(){delay(ev,ob)},cfg.timeout)}}};return this.bind('mouseenter',handleHover).bind('mouseleave',handleHover)}})(jQuery);

/**
* jQuery Plugin: "fieldhint"
*/
jQuery.fn.extend({fieldhint:function(options){return this.each(function(){new jQuery.FieldHint(this,options);});}});jQuery.FieldHint=function(element,options){var defaultValue=$(element).val();$(element).addClass("fieldhint-blur");$(element).bind("focus",function(e){if(defaultValue==$(this).val())
$(this).val('');$(this).removeClass("fieldhint-blur");}).bind("blur",function(e){if(!$(this).val()){$(this).val(defaultValue);$(this).addClass("fieldhint-blur");}});$("form:has(#"+element.id+")").bind('reset',function(e){$(element).val(defaultValue);$(element).removeClass(options.changeClass);$(element).addClass("fieldhint-blur");}).bind('submit',function(e){if($(element).val()==defaultValue) $(element).val('');});};

/**
 * jQuery Plugin: "qtip"
 * Copyright (c) 2009 Craig Thompson
 * http://craigsworks.com
 *
 * Version : 1.0.0-rc3
 */
(function(f){f.fn.qtip=function(B,u){var y,t,A,s,x,w,v,z;if(typeof B=="string"){if(f.isPlainObject(f(this).data("qtip"))){f.fn.qtip.log.error.call(self,1,f.fn.qtip.constants.NO_TOOLTIP_PRESENT,false)}if(B=="api"){return f(this).data("qtip").interfaces[f(this).data("qtip").current]}else{if(B=="interfaces"){return f(this).data("qtip").interfaces}}}else{if(!B){B={}}if(typeof B.content!=="object"||(B.content.jquery&&B.content.length>0)){B.content={text:B.content}}if(typeof B.content.title!=="object"){B.content.title={text:B.content.title}}if(typeof B.position!=="object"){B.position={corner:B.position}}if(typeof B.position.corner!=="object"){B.position.corner={target:B.position.corner,tooltip:B.position.corner}}if(typeof B.show!=="object"){B.show={when:B.show}}if(typeof B.show.when!=="object"){B.show.when={event:B.show.when}}if(typeof B.show.effect!=="object"){B.show.effect={type:B.show.effect}}if(typeof B.hide!=="object"){B.hide={when:B.hide}}if(typeof B.hide.when!=="object"){B.hide.when={event:B.hide.when}}if(typeof B.hide.effect!=="object"){B.hide.effect={type:B.hide.effect}}if(typeof B.style!=="object"){B.style={name:B.style}}B.style=c(B.style);s=f.extend(true,{},f.fn.qtip.defaults,B);s.style=a.call({options:s},s.style);s.user=f.extend(true,{},B)}return f(this).each(function(){if(typeof B=="string"){w=B.toLowerCase();A=f(this).qtip("interfaces");if(typeof A=="object"){if(u===true&&w=="destroy"){while(A.length>0){A[A.length-1].destroy()}}else{if(u!==true){A=[f(this).qtip("api")]}for(y=0;y<A.length;y++){if(w=="destroy"){A[y].destroy()}else{if(A[y].status.rendered===true){if(w=="show"){A[y].show()}else{if(w=="hide"){A[y].hide()}else{if(w=="focus"){A[y].focus()}else{if(w=="disable"){A[y].disable(true)}else{if(w=="enable"){A[y].disable(false)}}}}}}}}}}}else{v=f.extend(true,{},s);v.hide.effect.length=s.hide.effect.length;v.show.effect.length=s.show.effect.length;if(v.position.container===false){v.position.container=f(document.body)}if(v.position.target===false){v.position.target=f(this)}if(v.show.when.target===false){v.show.when.target=f(this)}if(v.hide.when.target===false){v.hide.when.target=f(this)}t=f.fn.qtip.interfaces.length;for(y=0;y<t;y++){if(typeof f(this).data("qtip")==="object"&&f(this).data("qtip")){}}x=new d(f(this),v,t);f.fn.qtip.interfaces[t]=x;if(f.isPlainObject(f(this).data("qtip"))){if(typeof f(this).attr("qtip")==="undefined"){f(this).data("qtip").current=f(this).data("qtip").interfaces.length}f(this).data("qtip").interfaces.push(x)}else{f(this).data("qtip",{current:0,interfaces:[x]})}if(v.content.prerender===false&&v.show.when.event!==false&&v.show.ready!==true){v.show.when.target.bind(v.show.when.event+".qtip-"+t+"-create",{qtip:t},function(C){z=f.fn.qtip.interfaces[C.data.qtip];z.options.show.when.target.unbind(z.options.show.when.event+".qtip-"+C.data.qtip+"-create");z.cache.mouse={x:C.pageX,y:C.pageY};p.call(z);z.options.show.when.target.trigger(z.options.show.when.event)})}else{x.cache.mouse={x:v.show.when.target.offset().left,y:v.show.when.target.offset().top};p.call(x)}}})};function d(u,t,v){var s=this;s.id=v;s.options=t;s.status={animated:false,rendered:false,disabled:false,focused:false};s.elements={target:u.addClass(s.options.style.classes.target),tooltip:null,wrapper:null,content:null,contentWrapper:null,title:null,button:null,tip:null,bgiframe:null};s.cache={mouse:{},position:{},toggle:0};s.timers={};f.extend(s,s.options.api,{show:function(y){var x,z;if(!s.status.rendered){return f.fn.qtip.log.error.call(s,2,f.fn.qtip.constants.TOOLTIP_NOT_RENDERED,"show")}if(s.elements.tooltip.css("display")!=="none"){return s}s.elements.tooltip.stop(true,false);x=s.beforeShow.call(s,y);if(x===false){return s}function w(){f(this).css({opacity:""});if(s.options.position.type!=="static"){s.focus()}s.onShow.call(s,y);if(f.browser.msie){s.elements.tooltip.get(0).style.removeAttribute("filter")}}s.cache.toggle=1;if(s.options.position.type!=="static"){s.updatePosition(y,(s.options.show.effect.length>0))}if(typeof s.options.show.solo=="object"){z=f(s.options.show.solo)}else{if(s.options.show.solo===true){z=f("div.qtip").not(s.elements.tooltip)}}if(z){z.each(function(){if(f(this).qtip("api").status.rendered===true){f(this).qtip("api").hide()}})}if(typeof s.options.show.effect.type=="function"){s.options.show.effect.type.call(s.elements.tooltip,s.options.show.effect.length);s.elements.tooltip.queue(function(){w();f(this).dequeue()})}else{switch(s.options.show.effect.type.toLowerCase()){case"fade":s.elements.tooltip.fadeIn(s.options.show.effect.length,w);break;case"slide":s.elements.tooltip.slideDown(s.options.show.effect.length,function(){w();if(s.options.position.type!=="static"){s.updatePosition(y,true)}});break;case"grow":s.elements.tooltip.show(s.options.show.effect.length,w);break;default:s.elements.tooltip.show(null,w);s.elements.tooltip.css({opacity:""});break}s.elements.tooltip.addClass(s.options.style.classes.active)}return f.fn.qtip.log.error.call(s,1,f.fn.qtip.constants.EVENT_SHOWN,"show")},hide:function(y){var x;if(!s.status.rendered){return f.fn.qtip.log.error.call(s,2,f.fn.qtip.constants.TOOLTIP_NOT_RENDERED,"hide")}else{if(s.elements.tooltip.css("display")==="none"){return s}}clearTimeout(s.timers.show);s.elements.tooltip.stop(true,false);x=s.beforeHide.call(s,y);if(x===false){return s}function w(){s.onHide.call(s,y)}s.cache.toggle=0;if(typeof s.options.hide.effect.type=="function"){s.options.hide.effect.type.call(s.elements.tooltip,s.options.hide.effect.length);s.elements.tooltip.queue(function(){w();f(this).dequeue()})}else{switch(s.options.hide.effect.type.toLowerCase()){case"fade":s.elements.tooltip.fadeOut(s.options.hide.effect.length,w);break;case"slide":s.elements.tooltip.slideUp(s.options.hide.effect.length,w);break;case"grow":s.elements.tooltip.hide(s.options.hide.effect.length,w);break;default:s.elements.tooltip.hide(null,w);break}s.elements.tooltip.removeClass(s.options.style.classes.active)}return f.fn.qtip.log.error.call(s,1,f.fn.qtip.constants.EVENT_HIDDEN,"hide")},updatePosition:function(w,x){var C,G,L,J,H,E,y,I,B,D,K,A,F,z;if(!s.status.rendered){return f.fn.qtip.log.error.call(s,2,f.fn.qtip.constants.TOOLTIP_NOT_RENDERED,"updatePosition")}else{if(s.options.position.type=="static"){return f.fn.qtip.log.error.call(s,1,f.fn.qtip.constants.CANNOT_POSITION_STATIC,"updatePosition")}}G={position:{left:0,top:0},dimensions:{height:0,width:0},corner:s.options.position.corner.target};L={position:s.getPosition(),dimensions:s.getDimensions(),corner:s.options.position.corner.tooltip};if(s.options.position.target!=="mouse"){if(s.options.position.target.get(0).nodeName.toLowerCase()=="area"){J=s.options.position.target.attr("coords").split(",");for(C=0;C<J.length;C++){J[C]=parseInt(J[C])}H=s.options.position.target.parent("map").attr("name");E=f('img[usemap="#'+H+'"]:first').offset();G.position={left:Math.floor(E.left+J[0]),top:Math.floor(E.top+J[1])};switch(s.options.position.target.attr("shape").toLowerCase()){case"rect":G.dimensions={width:Math.ceil(Math.abs(J[2]-J[0])),height:Math.ceil(Math.abs(J[3]-J[1]))};break;case"circle":G.dimensions={width:J[2]+1,height:J[2]+1};break;case"poly":G.dimensions={width:J[0],height:J[1]};for(C=0;C<J.length;C++){if(C%2==0){if(J[C]>G.dimensions.width){G.dimensions.width=J[C]}if(J[C]<J[0]){G.position.left=Math.floor(E.left+J[C])}}else{if(J[C]>G.dimensions.height){G.dimensions.height=J[C]}if(J[C]<J[1]){G.position.top=Math.floor(E.top+J[C])}}}G.dimensions.width=G.dimensions.width-(G.position.left-E.left);G.dimensions.height=G.dimensions.height-(G.position.top-E.top);break;default:return f.fn.qtip.log.error.call(s,4,f.fn.qtip.constants.INVALID_AREA_SHAPE,"updatePosition");break}G.dimensions.width-=2;G.dimensions.height-=2}else{if(s.options.position.target.add(document.body).length===1){G.position={left:f(document).scrollLeft(),top:f(document).scrollTop()};G.dimensions={height:f(window).height(),width:f(window).width()}}else{if(typeof s.options.position.target.attr("qtip")!=="undefined"){G.position=s.options.position.target.qtip("api").cache.position}else{G.position=s.options.position.target.offset()}G.dimensions={height:s.options.position.target.outerHeight(),width:s.options.position.target.outerWidth()}}}y=f.extend({},G.position);if((/right/i).test(G.corner)){y.left+=G.dimensions.width}if((/bottom/i).test(G.corner)){y.top+=G.dimensions.height}if((/((top|bottom)Middle)|center/).test(G.corner)){y.left+=(G.dimensions.width/2)}if((/((left|right)Middle)|center/).test(G.corner)){y.top+=(G.dimensions.height/2)}}else{G.position=y={left:s.cache.mouse.x,top:s.cache.mouse.y};G.dimensions={height:1,width:1}}if((/right/i).test(L.corner)){y.left-=L.dimensions.width}if((/bottom/i).test(L.corner)){y.top-=L.dimensions.height}if((/((top|bottom)Middle)|center/).test(L.corner)){y.left-=(L.dimensions.width/2)}if((/((left|right)Middle)|center/).test(L.corner)){y.top-=(L.dimensions.height/2)}I=(f.browser.msie)?1:0;B=(f.browser.msie&&parseInt(f.browser.version.charAt(0))===6)?1:0;if(s.options.style.border.radius>0){if((/Left/i).test(L.corner)){y.left-=s.options.style.border.radius}else{if((/Right/i).test(L.corner)){y.left+=s.options.style.border.radius}}if((/Top/i).test(L.corner)){y.top-=s.options.style.border.radius}else{if((/Bottom/i).test(L.corner)){y.top+=s.options.style.border.radius}}}if(I){if((/top/i).test(L.corner)){y.top-=I}else{if((/bottom/i).test(L.corner)){y.top+=I}}if((/left/i).test(L.corner)){y.left-=I}else{if((/right/i).test(L.corner)){y.left+=I}}if((/leftMiddle|rightMiddle/).test(L.corner)){y.top-=1}}if(s.options.position.adjust.screen===true){y=o.call(s,y,G,L)}if(s.options.position.target==="mouse"&&s.options.position.adjust.mouse===true){if(s.options.position.adjust.screen===true&&s.elements.tip){K=s.elements.tip.attr("rel")}else{K=s.options.position.corner.tooltip}y.left+=((/right/i).test(K))?-6:6;y.top+=((/bottom/i).test(K))?-6:6}if(!s.elements.bgiframe&&f.browser.msie&&parseInt(f.browser.version.charAt(0))==6){f("select, object").each(function(){A=f(this).offset();A.bottom=A.top+f(this).height();A.right=A.left+f(this).width();if(y.top+L.dimensions.height>=A.top&&y.left+L.dimensions.width>=A.left){k.call(s)}})}y.left+=s.options.position.adjust.x;y.top+=s.options.position.adjust.y;F=s.getPosition();if(y.left!=F.left||y.top!=F.top){z=s.beforePositionUpdate.call(s,w);if(z===false){return s}s.cache.position=y;if(x===true){s.status.animated=true;s.elements.tooltip.animate(y,200,"swing",function(){s.status.animated=false})}else{s.elements.tooltip.css(y)}s.onPositionUpdate.call(s,w);if(typeof w!=="undefined"&&w.type&&w.type!=="mousemove"){f.fn.qtip.log.error.call(s,1,f.fn.qtip.constants.EVENT_POSITION_UPDATED,"updatePosition")}}return s},updateWidth:function(z){if(!s.status.rendered){return f.fn.qtip.log.error.call(s,2,f.fn.qtip.constants.TOOLTIP_NOT_RENDERED,"updateWidth")}else{if(z!=undefined&&typeof z!=="number"){return f.fn.qtip.log.error.call(s,2,"newWidth must be of type number","updateWidth")}}var B=s.elements.contentWrapper.siblings().add(s.elements.tip).add(s.elements.button),y=s.elements.wrapper.add(s.elements.contentWrapper.children()),A=s.elements.tooltip,w=s.options.style.width.max,x=s.options.style.width.min;if(!z){if(typeof s.options.style.width.value==="number"){z=s.options.style.width.value}else{s.elements.tooltip.css({width:"auto"});B.hide();if(f.browser.msie){y.css({zoom:""})}z=s.getDimensions().width;if(!s.options.style.width.value){z=Math.min(Math.max(z,x),w)}}}if(z%2){z-=1}s.elements.tooltip.width(z);B.show();if(s.options.style.border.radius){s.elements.tooltip.find(".qtip-betweenCorners").each(function(C){f(this).width(z-(s.options.style.border.radius*2))})}if(f.browser.msie){y.css({zoom:1});if(s.elements.bgiframe){s.elements.bgiframe.width(z).height(s.getDimensions.height)}}return f.fn.qtip.log.error.call(s,1,f.fn.qtip.constants.EVENT_WIDTH_UPDATED,"updateWidth")},updateStyle:function(w){var z,A,x,y,B;if(!s.status.rendered){return f.fn.qtip.log.error.call(s,2,f.fn.qtip.constants.TOOLTIP_NOT_RENDERED,"updateStyle")}else{if(typeof w!=="string"||!f.fn.qtip.styles[w]){return f.fn.qtip.log.error.call(s,2,f.fn.qtip.constants.STYLE_NOT_DEFINED,"updateStyle")}}s.options.style=a.call(s,f.fn.qtip.styles[w],s.options.user.style);s.elements.content.css(q(s.options.style));if(s.options.content.title.text!==false){s.elements.title.css(q(s.options.style.title,true))}s.elements.contentWrapper.css({borderColor:s.options.style.border.color});if(s.options.style.tip.corner!==false){if(f("<canvas>").get(0).getContext){z=s.elements.tooltip.find(".qtip-tip canvas:first");x=z.get(0).getContext("2d");x.clearRect(0,0,300,300);y=z.parent("div[rel]:first").attr("rel");B=b(y,s.options.style.tip.size.width,s.options.style.tip.size.height);h.call(s,z,B,s.options.style.tip.color||s.options.style.border.color)}else{if(f.browser.msie){z=s.elements.tooltip.find('.qtip-tip [nodeName="shape"]');z.attr("fillcolor",s.options.style.tip.color||s.options.style.border.color)}}}if(s.options.style.border.radius>0){s.elements.tooltip.find(".qtip-betweenCorners").css({backgroundColor:s.options.style.border.color});if(f("<canvas>").get(0).getContext){A=g(s.options.style.border.radius);s.elements.tooltip.find(".qtip-wrapper canvas").each(function(){x=f(this).get(0).getContext("2d");x.clearRect(0,0,300,300);y=f(this).parent("div[rel]:first").attr("rel");r.call(s,f(this),A[y],s.options.style.border.radius,s.options.style.border.color)})}else{if(f.browser.msie){s.elements.tooltip.find('.qtip-wrapper [nodeName="arc"]').each(function(){f(this).attr("fillcolor",s.options.style.border.color)})}}}return f.fn.qtip.log.error.call(s,1,f.fn.qtip.constants.EVENT_STYLE_UPDATED,"updateStyle")},updateContent:function(A,y){var z,x,w;if(!s.status.rendered){return f.fn.qtip.log.error.call(s,2,f.fn.qtip.constants.TOOLTIP_NOT_RENDERED,"updateContent")}else{if(!A){return f.fn.qtip.log.error.call(s,2,f.fn.qtip.constants.NO_CONTENT_PROVIDED,"updateContent")}}z=s.beforeContentUpdate.call(s,A);if(typeof z=="string"){A=z}else{if(z===false){return}}if(f.browser.msie){s.elements.contentWrapper.children().css({zoom:"normal"})}if(A.jquery&&A.length>0){A.clone(true).appendTo(s.elements.content).show()}else{s.elements.content.html(A)}w=0;x=s.elements.content.find("img");if(x.length){if(f.fn.qtip.preload){x.each(function(){preloaded=f('body > img[src="'+f(this).attr("src")+'"]:first');if(preloaded.length>0){f(this).attr("width",preloaded.innerWidth()).attr("height",preloaded.innerHeight())}});B()}else{x.bind("load error",function(){if(++w===x.length){B()}})}}else{B()}function B(){s.updateWidth();if(y!==false){if(s.options.position.type!=="static"){s.updatePosition(s.elements.tooltip.is(":visible"),true)}if(s.options.style.tip.corner!==false){n.call(s)}}}s.updateWidth();if(y!==false){if(s.options.position.type!=="static"){s.updatePosition(s.elements.tooltip.is(":visible"),true)}if(s.options.style.tip.corner!==false){n.call(s)}}s.onContentUpdate.call(s);return f.fn.qtip.log.error.call(s,1,f.fn.qtip.constants.EVENT_CONTENT_UPDATED,"loadContent")},loadContent:function(w,z,A){var y;if(!s.status.rendered){return f.fn.qtip.log.error.call(s,2,f.fn.qtip.constants.TOOLTIP_NOT_RENDERED,"loadContent")}y=s.beforeContentLoad.call(s);if(y===false){return s}if(A=="post"){f.post(w,z,x)}else{f.get(w,z,x)}function x(B){s.onContentLoad.call(s);f.fn.qtip.log.error.call(s,1,f.fn.qtip.constants.EVENT_CONTENT_LOADED,"loadContent");s.updateContent(B)}return s},updateTitle:function(w){if(!s.status.rendered){return f.fn.qtip.log.error.call(s,2,f.fn.qtip.constants.TOOLTIP_NOT_RENDERED,"updateTitle")}else{if(!w){return f.fn.qtip.log.error.call(s,2,f.fn.qtip.constants.NO_CONTENT_PROVIDED,"updateTitle")}}returned=s.beforeTitleUpdate.call(s);if(returned===false){return s}if(s.elements.button){s.elements.button=s.elements.button.clone(true)}s.elements.title.html(w);if(s.elements.button){s.elements.title.prepend(s.elements.button)}s.onTitleUpdate.call(s);return f.fn.qtip.log.error.call(s,1,f.fn.qtip.constants.EVENT_TITLE_UPDATED,"updateTitle")},focus:function(A){var y,x,w,z;if(!s.status.rendered){return f.fn.qtip.log.error.call(s,2,f.fn.qtip.constants.TOOLTIP_NOT_RENDERED,"focus")}else{if(s.options.position.type=="static"){return f.fn.qtip.log.error.call(s,1,f.fn.qtip.constants.CANNOT_FOCUS_STATIC,"focus")}}y=parseInt(s.elements.tooltip.css("z-index"));x=32001+f("div.qtip[qtip]").length-1;if(!s.status.focused&&y!==x){z=s.beforeFocus.call(s,A);if(z===false){return s}f("div.qtip[qtip]").not(s.elements.tooltip).each(function(){if(f(this).qtip("api").status.rendered===true){w=parseInt(f(this).css("z-index"));if(typeof w=="number"&&w>-1){f(this).css({zIndex:parseInt(f(this).css("z-index"))-1})}f(this).qtip("api").status.focused=false}});s.elements.tooltip.css({zIndex:x});s.status.focused=true;s.onFocus.call(s,A);f.fn.qtip.log.error.call(s,1,f.fn.qtip.constants.EVENT_FOCUSED,"focus")}return s},disable:function(w){if(!s.status.rendered){return f.fn.qtip.log.error.call(s,2,f.fn.qtip.constants.TOOLTIP_NOT_RENDERED,"disable")}if(w){if(!s.status.disabled){s.status.disabled=true;f.fn.qtip.log.error.call(s,1,f.fn.qtip.constants.EVENT_DISABLED,"disable")}else{f.fn.qtip.log.error.call(s,1,f.fn.qtip.constants.TOOLTIP_ALREADY_DISABLED,"disable")}}else{if(s.status.disabled){s.status.disabled=false;f.fn.qtip.log.error.call(s,1,f.fn.qtip.constants.EVENT_ENABLED,"disable")}else{f.fn.qtip.log.error.call(s,1,f.fn.qtip.constants.TOOLTIP_ALREADY_ENABLED,"disable")}}return s},destroy:function(){var w,x,y;x=s.beforeDestroy.call(s);if(x===false){return s}if(s.status.rendered){s.options.show.when.target.unbind("mousemove.qtip",s.updatePosition);s.options.show.when.target.unbind("mouseout.qtip",s.hide);s.options.show.when.target.unbind(s.options.show.when.event+".qtip");s.options.hide.when.target.unbind(s.options.hide.when.event+".qtip");s.elements.tooltip.unbind(s.options.hide.when.event+".qtip");s.elements.tooltip.unbind("mouseover.qtip",s.focus);s.elements.tooltip.remove()}else{s.options.show.when.target.unbind(s.options.show.when.event+".qtip-create")}if(typeof s.elements.target.data("qtip")=="object"){y=s.elements.target.data("qtip").interfaces;if(typeof y=="object"&&y.length>0){for(w=0;w<y.length-1;w++){if(y[w].id==s.id){y.splice(w,1)}}}}f.fn.qtip.interfaces.splice(s.id,1);if(typeof y=="object"&&y.length>0){s.elements.target.data("qtip").current=y.length-1}else{s.elements.target.removeData("qtip")}s.onDestroy.call(s);f.fn.qtip.log.error.call(s,1,f.fn.qtip.constants.EVENT_DESTROYED,"destroy");return s.elements.target},getPosition:function(){var w,x;if(!s.status.rendered){return f.fn.qtip.log.error.call(s,2,f.fn.qtip.constants.TOOLTIP_NOT_RENDERED,"getPosition")}w=(s.elements.tooltip.css("display")!=="none")?false:true;if(w){s.elements.tooltip.css({visiblity:"hidden"}).show()}x=s.elements.tooltip.offset();if(w){s.elements.tooltip.css({visiblity:"visible"}).hide()}return x},getDimensions:function(){var w,x;if(!s.status.rendered){return f.fn.qtip.log.error.call(s,2,f.fn.qtip.constants.TOOLTIP_NOT_RENDERED,"getDimensions")}w=(!s.elements.tooltip.is(":visible"))?true:false;if(w){s.elements.tooltip.css({visiblity:"hidden"}).show()}x={height:s.elements.tooltip.outerHeight(),width:s.elements.tooltip.outerWidth()};if(w){s.elements.tooltip.css({visiblity:"visible"}).hide()}return x}})}function p(){var s,w,u,t,v,y,x;s=this;s.beforeRender.call(s);s.status.rendered=true;s.elements.tooltip='<div qtip="'+s.id+'" class="qtip '+(s.options.style.classes.tooltip||s.options.style)+'"style="display:none; -moz-border-radius:0; -webkit-border-radius:0; border-radius:0;position:'+s.options.position.type+';">  <div class="qtip-wrapper" style="position:relative; overflow:hidden; text-align:left;">    <div class="qtip-contentWrapper" style="overflow:hidden;">       <div class="qtip-content '+s.options.style.classes.content+'"></div></div></div></div>';s.elements.tooltip=f(s.elements.tooltip);s.elements.tooltip.appendTo(s.options.position.container);s.elements.tooltip.data("qtip",{current:0,interfaces:[s]});s.elements.wrapper=s.elements.tooltip.children("div:first");s.elements.contentWrapper=s.elements.wrapper.children("div:first").css({background:s.options.style.background});s.elements.content=s.elements.contentWrapper.children("div:first").css(q(s.options.style));if(f.browser.msie){s.elements.wrapper.add(s.elements.content).css({zoom:1})}if((/unfocus/i).test(s.options.hide.when.event)){s.elements.tooltip.attr("unfocus",true)}if(typeof s.options.style.width.value=="number"){s.updateWidth()}if(f("<canvas>").get(0).getContext||f.browser.msie){if(s.options.style.border.radius>0){m.call(s)}else{s.elements.contentWrapper.css({border:s.options.style.border.width+"px solid "+s.options.style.border.color})}if(s.options.style.tip.corner!==false){e.call(s)}}else{s.elements.contentWrapper.css({border:s.options.style.border.width+"px solid "+s.options.style.border.color});s.options.style.border.radius=0;s.options.style.tip.corner=false;f.fn.qtip.log.error.call(s,2,f.fn.qtip.constants.CANVAS_VML_NOT_SUPPORTED,"render")}if((typeof s.options.content.text=="string"&&s.options.content.text.length>0)||(s.options.content.text.jquery&&s.options.content.text.length>0)){u=s.options.content.text}else{if(typeof s.elements.target.attr("title")=="string"&&s.elements.target.attr("title").length>0){u=s.elements.target.attr("title").replace("\\n","<br />");s.elements.target.attr("title","")}else{if(typeof s.elements.target.attr("alt")=="string"&&s.elements.target.attr("alt").length>0){u=s.elements.target.attr("alt").replace("\\n","<br />");s.elements.target.attr("alt","")}else{u=" ";f.fn.qtip.log.error.call(s,1,f.fn.qtip.constants.NO_VALID_CONTENT,"render")}}}if(s.options.content.title.text!==false){j.call(s)}s.updateContent(u);l.call(s);if(s.options.show.ready===true){s.show()}if(s.options.content.url!==false){t=s.options.content.url;v=s.options.content.data;y=s.options.content.method||"get";s.loadContent(t,v,y)}s.onRender.call(s);f.fn.qtip.log.error.call(s,1,f.fn.qtip.constants.EVENT_RENDERED,"render")}function m(){var F,z,t,B,x,E,u,G,D,y,w,C,A,s,v;F=this;F.elements.wrapper.find(".qtip-borderBottom, .qtip-borderTop").remove();t=F.options.style.border.width;B=F.options.style.border.radius;x=F.options.style.border.color||F.options.style.tip.color;E=g(B);u={};for(z in E){u[z]='<div rel="'+z+'" style="'+((/Left/).test(z)?"left":"right")+":0; position:absolute; height:"+B+"px; width:"+B+'px; overflow:hidden; line-height:0.1px; font-size:1px">';if(f("<canvas>").get(0).getContext){u[z]+='<canvas height="'+B+'" width="'+B+'" style="vertical-align: top"></canvas>'}else{if(f.browser.msie){G=B*2+3;u[z]+='<v:arc stroked="false" fillcolor="'+x+'" startangle="'+E[z][0]+'" endangle="'+E[z][1]+'" style="width:'+G+"px; height:"+G+"px; margin-top:"+((/bottom/).test(z)?-2:-1)+"px; margin-left:"+((/Right/).test(z)?E[z][2]-3.5:-1)+'px; vertical-align:top; display:inline-block; behavior:url(#default#VML)"></v:arc>'}}u[z]+="</div>"}D=F.getDimensions().width-(Math.max(t,B)*2);y='<div class="qtip-betweenCorners" style="height:'+B+"px; width:"+D+"px; overflow:hidden; background-color:"+x+'; line-height:0.1px; font-size:1px;">';w='<div class="qtip-borderTop" dir="ltr" style="height:'+B+"px; margin-left:"+B+'px; line-height:0.1px; font-size:1px; padding:0;">'+u.topLeft+u.topRight+y;F.elements.wrapper.prepend(w);C='<div class="qtip-borderBottom" dir="ltr" style="height:'+B+"px; margin-left:"+B+'px; line-height:0.1px; font-size:1px; padding:0;">'+u.bottomLeft+u.bottomRight+y;F.elements.wrapper.append(C);if(f("<canvas>").get(0).getContext){F.elements.wrapper.find("canvas").each(function(){A=E[f(this).parent("[rel]:first").attr("rel")];r.call(F,f(this),A,B,x)})}else{if(f.browser.msie){F.elements.tooltip.append('<v:image style="behavior:url(#default#VML);"></v:image>')}}s=Math.max(B,(B+(t-B)));v=Math.max(t-B,0);F.elements.contentWrapper.css({border:"0px solid "+x,borderWidth:v+"px "+s+"px"})}function r(u,w,s,t){var v=u.get(0).getContext("2d");v.fillStyle=t;v.beginPath();v.arc(w[0],w[1],s,0,Math.PI*2,false);v.fill()}function e(v){var t,s,y,u,x,w;t=this;if(t.elements.tip!==null){t.elements.tip.remove()}s=t.options.style.tip.color||t.options.style.border.color;if(t.options.style.tip.corner===false){return}else{if(!v){v=t.options.style.tip.corner}}y=b(v,t.options.style.tip.size.width,t.options.style.tip.size.height);t.elements.tip='<div class="'+t.options.style.classes.tip+'" dir="ltr" rel="'+v+'" style="position:absolute; height:'+t.options.style.tip.size.height+"px; width:"+t.options.style.tip.size.width+'px; margin:0 auto; line-height:0.1px; font-size:1px;"></div>';t.elements.tooltip.prepend(t.elements.tip);if(f("<canvas>").get(0).getContext){w='<canvas height="'+t.options.style.tip.size.height+'" width="'+t.options.style.tip.size.width+'"></canvas>'}else{if(f.browser.msie){u=t.options.style.tip.size.width+","+t.options.style.tip.size.height;x="m"+y[0][0]+","+y[0][1];x+=" l"+y[1][0]+","+y[1][1];x+=" "+y[2][0]+","+y[2][1];x+=" xe";w='<v:shape fillcolor="'+s+'" stroked="false" filled="true" path="'+x+'" coordsize="'+u+'" style="width:'+t.options.style.tip.size.width+"px; height:"+t.options.style.tip.size.height+"px; line-height:0.1px; display:inline-block; behavior:url(#default#VML); vertical-align:"+((/top/).test(v)?"bottom":"top")+'"></v:shape>';w+='<v:image style="behavior:url(#default#VML);"></v:image>';t.elements.contentWrapper.css("position","relative")}}t.elements.tip=t.elements.tooltip.find("."+t.options.style.classes.tip).eq(0);t.elements.tip.html(w);if(f("<canvas>").get(0).getContext){h.call(t,t.elements.tip.find("canvas:first"),y,s)}if((/top/).test(v)&&f.browser.msie&&parseInt(f.browser.version.charAt(0))===6){t.elements.tip.css({marginTop:-4})}n.call(t,v)}function h(t,v,s){var u=t.get(0).getContext("2d");u.fillStyle=s;u.beginPath();u.moveTo(v[0][0],v[0][1]);u.lineTo(v[1][0],v[1][1]);u.lineTo(v[2][0],v[2][1]);u.fill()}function n(u){var t,w,s,x,v;t=this;if(t.options.style.tip.corner===false||!t.elements.tip){return}if(!u){u=t.elements.tip.attr("rel")}w=positionAdjust=(f.browser.msie)?1:0;t.elements.tip.css(u.match(/left|right|top|bottom/)[0],0);if((/top|bottom/).test(u)){if(f.browser.msie){if(parseInt(f.browser.version.charAt(0))===6){positionAdjust=((/top/).test(u))?-3:1}else{positionAdjust=((/top/).test(u))?1:2}}if((/Middle/).test(u)){t.elements.tip.css({left:"50%",marginLeft:-(t.options.style.tip.size.width/2)})}else{if((/Left/).test(u)){t.elements.tip.css({left:t.options.style.border.radius-w})}else{if((/Right/).test(u)){t.elements.tip.css({right:t.options.style.border.radius+w})}}}if((/top/).test(u)){t.elements.tip.css({top:-positionAdjust})}else{t.elements.tip.css({bottom:positionAdjust})}}else{if((/left|right/).test(u)){if(f.browser.msie){positionAdjust=(parseInt(f.browser.version.charAt(0))===6)?1:((/left/).test(u)?1:2)}if((/Middle/).test(u)){t.elements.tip.css({top:"50%",marginTop:-(t.options.style.tip.size.height/2)})}else{if((/Top/).test(u)){t.elements.tip.css({top:t.options.style.border.radius-w})}else{if((/Bottom/).test(u)){t.elements.tip.css({bottom:t.options.style.border.radius+w})}}}if((/left/).test(u)){t.elements.tip.css({left:-positionAdjust})}else{t.elements.tip.css({right:positionAdjust})}}}s="padding-"+u.match(/left|right|top|bottom/)[0];x=t.options.style.tip.size[(/left|right/).test(s)?"width":"height"];t.elements.tooltip.css("padding",0);t.elements.tooltip.css(s,x);if(f.browser.msie&&parseInt(f.browser.version.charAt(0))==6){v=parseInt(t.elements.tip.css("margin-top"))||0;v+=parseInt(t.elements.content.css("margin-top"))||0;t.elements.tip.css({marginTop:v})}}function j(){var s=this;if(s.elements.title!==null){s.elements.title.remove()}s.elements.title=f('<div class="'+s.options.style.classes.title+'">').css(q(s.options.style.title,true)).css({zoom:(f.browser.msie)?1:0}).prependTo(s.elements.contentWrapper);if(s.options.content.title.text){s.updateTitle.call(s,s.options.content.title.text)}if(s.options.content.title.button!==false&&typeof s.options.content.title.button=="string"){s.elements.button=f('<a class="'+s.options.style.classes.button+'" style="float:right; position: relative"></a>').css(q(s.options.style.button,true)).html(s.options.content.title.button).prependTo(s.elements.title).click(function(t){if(!s.status.disabled){s.hide(t)}})}}function l(){var t,v,u,s;t=this;v=t.options.show.when.target;u=t.options.hide.when.target;if(t.options.hide.fixed){u=u.add(t.elements.tooltip)}if(t.options.hide.when.event=="inactive"){s=["click","dblclick","mousedown","mouseup","mousemove","mouseout","mouseenter","mouseleave","mouseover","touchstart"];function y(z){if(t.status.disabled===true){return}clearTimeout(t.timers.inactive);t.timers.inactive=setTimeout(function(){f(s).each(function(){u.unbind(this+".qtip-inactive");t.elements.content.unbind(this+".qtip-inactive")});t.hide(z)},t.options.hide.delay)}}else{if(t.options.hide.fixed===true){t.elements.tooltip.bind("mouseover.qtip",function(){if(t.status.disabled===true){return}clearTimeout(t.timers.hide)})}}function x(z){if(t.status.disabled===true){return}if(t.options.hide.when.event=="inactive"){f(s).each(function(){u.bind(this+".qtip-inactive",y);t.elements.content.bind(this+".qtip-inactive",y)});y()}clearTimeout(t.timers.show);clearTimeout(t.timers.hide);if(t.options.show.delay>0){t.timers.show=setTimeout(function(){t.show(z)},t.options.show.delay)}else{t.show(z)}}function w(z){if(t.status.disabled===true){return}if(t.options.hide.fixed===true&&(/mouse(out|leave)/i).test(t.options.hide.when.event)&&f(z.relatedTarget).parents("div.qtip[qtip]").length>0){z.stopPropagation();z.preventDefault();clearTimeout(t.timers.hide);return false}clearTimeout(t.timers.show);clearTimeout(t.timers.hide);t.elements.tooltip.stop(true,true);t.timers.hide=setTimeout(function(){t.hide(z)},t.options.hide.delay)}if((t.options.show.when.target.add(t.options.hide.when.target).length===1&&t.options.show.when.event==t.options.hide.when.event&&t.options.hide.when.event!=="inactive")||t.options.hide.when.event=="unfocus"){t.cache.toggle=0;v.bind(t.options.show.when.event+".qtip",function(z){if(t.cache.toggle==0){x(z)}else{w(z)}})}else{v.bind(t.options.show.when.event+".qtip",x);if(t.options.hide.when.event!=="inactive"){u.bind(t.options.hide.when.event+".qtip",w)}}if((/(fixed|absolute)/).test(t.options.position.type)){t.elements.tooltip.bind("mouseover.qtip",t.focus)}if(t.options.position.target==="mouse"&&t.options.position.type!=="static"){v.bind("mousemove.qtip",function(z){t.cache.mouse={x:z.pageX,y:z.pageY};if(t.status.disabled===false&&t.options.position.adjust.mouse===true&&t.options.position.type!=="static"&&t.elements.tooltip.css("display")!=="none"){t.updatePosition(z)}})}}function o(u,v,A){var z,s,x,y,t,w;z=this;if(A.corner=="center"){return v.position}s=f.extend({},u);y={x:false,y:false};t={left:(s.left<f.fn.qtip.cache.screen.scroll.left),right:(s.left+A.dimensions.width+2>=f.fn.qtip.cache.screen.width+f.fn.qtip.cache.screen.scroll.left),top:(s.top<f.fn.qtip.cache.screen.scroll.top),bottom:(s.top+A.dimensions.height+2>=f.fn.qtip.cache.screen.height+f.fn.qtip.cache.screen.scroll.top)};x={left:(t.left&&((/right/i).test(A.corner)||!t.right)),right:(t.right&&((/left/i).test(A.corner)||!t.left)),top:(t.top&&!(/top/i).test(A.corner)),bottom:(t.bottom&&!(/bottom/i).test(A.corner))};if(x.left){if(z.options.position.target!=="mouse"){s.left=v.position.left+v.dimensions.width}else{s.left=z.cache.mouse.x}y.x="Left"}else{if(x.right){if(z.options.position.target!=="mouse"){s.left=v.position.left-A.dimensions.width}else{s.left=z.cache.mouse.x-A.dimensions.width}y.x="Right"}}if(x.top){if(z.options.position.target!=="mouse"){s.top=v.position.top+v.dimensions.height}else{s.top=z.cache.mouse.y}y.y="top"}else{if(x.bottom){if(z.options.position.target!=="mouse"){s.top=v.position.top-A.dimensions.height}else{s.top=z.cache.mouse.y-A.dimensions.height}y.y="bottom"}}if(s.left<0){s.left=u.left;y.x=false}if(s.top<0){s.top=u.top;y.y=false}if(z.options.style.tip.corner!==false){s.corner=new String(A.corner);if(s.corner.match(/^(right|left)/)){if(y.x!==false){s.corner=s.corner.replace(/(left|right)/,y.x.toLowerCase())}}else{if(y.x!==false){s.corner=s.corner.replace(/Left|Right|Middle/,y.x)}if(y.y!==false){s.corner=s.corner.replace(/top|bottom/,y.y)}}if(s.corner!==z.elements.tip.attr("rel")){e.call(z,s.corner)}}return s}function q(u,t){var v,s;v=f.extend(true,{},u);for(s in v){if(t===true&&(/(tip|classes)/i).test(s)){delete v[s]}else{if(!t&&(/(width|border|tip|title|classes|user)/i).test(s)){delete v[s]}}}return v}function c(s){if(typeof s.tip!=="object"){s.tip={corner:s.tip}}if(typeof s.tip.size!=="object"){s.tip.size={width:s.tip.size,height:s.tip.size}}if(typeof s.border!=="object"){s.border={width:s.border}}if(typeof s.width!=="object"){s.width={value:s.width}}if(typeof s.width.max=="string"){s.width.max=parseInt(s.width.max.replace(/([0-9]+)/i,"$1"))}if(typeof s.width.min=="string"){s.width.min=parseInt(s.width.min.replace(/([0-9]+)/i,"$1"))}if(typeof s.tip.size.x=="number"){s.tip.size.width=s.tip.size.x;delete s.tip.size.x}if(typeof s.tip.size.y=="number"){s.tip.size.height=s.tip.size.y;delete s.tip.size.y}return s}function a(){var s,t,u,x,v,w;s=this;u=[true,{}];for(t=0;t<arguments.length;t++){u.push(arguments[t])}x=[f.extend.apply(f,u)];while(typeof x[0].name=="string"){x.unshift(c(f.fn.qtip.styles[x[0].name]))}x.unshift(true,{classes:{tooltip:"qtip-"+(arguments[0].name||"defaults")}},f.fn.qtip.styles.defaults);v=f.extend.apply(f,x);w=(f.browser.msie)?1:0;v.tip.size.width+=w;v.tip.size.height+=w;if(v.tip.size.width%2>0){v.tip.size.width+=1}if(v.tip.size.height%2>0){v.tip.size.height+=1}if(v.tip.corner===true){v.tip.corner=(s.options.position.corner.tooltip==="center")?false:s.options.position.corner.tooltip}return v}function b(v,u,t){var s={bottomRight:[[0,0],[u,t],[u,0]],bottomLeft:[[0,0],[u,0],[0,t]],topRight:[[0,t],[u,0],[u,t]],topLeft:[[0,0],[0,t],[u,t]],topMiddle:[[0,t],[u/2,0],[u,t]],bottomMiddle:[[0,0],[u,0],[u/2,t]],rightMiddle:[[0,0],[u,t/2],[0,t]],leftMiddle:[[u,0],[u,t],[0,t/2]]};s.leftTop=s.bottomRight;s.rightTop=s.bottomLeft;s.leftBottom=s.topRight;s.rightBottom=s.topLeft;return s[v]}function g(s){var t;if(f("<canvas>").get(0).getContext){t={topLeft:[s,s],topRight:[0,s],bottomLeft:[s,0],bottomRight:[0,0]}}else{if(f.browser.msie){t={topLeft:[-90,90,0],topRight:[-90,90,-s],bottomLeft:[90,270,0],bottomRight:[90,270,-s]}}}return t}function k(){var s,t,u;s=this;u=s.getDimensions();t='<iframe class="qtip-bgiframe" frameborder="0" tabindex="-1" src="javascript:false" style="display:block; position:absolute; z-index:-1; filter:alpha(opacity=\'0\'); border: 1px solid red; height:'+u.height+"px; width:"+u.width+'px" />';s.elements.bgiframe=s.elements.wrapper.prepend(t).children(".qtip-bgiframe:first")}f(document).ready(function(){f.fn.qtip.cache={screen:{scroll:{left:f(window).scrollLeft(),top:f(window).scrollTop()},width:f(window).width(),height:f(window).height()}};var s;f(window).bind("resize scroll",function(t){clearTimeout(s);s=setTimeout(function(){if(t.type==="scroll"){f.fn.qtip.cache.screen.scroll={left:f(window).scrollLeft(),top:f(window).scrollTop()}}else{f.fn.qtip.cache.screen.width=f(window).width();f.fn.qtip.cache.screen.height=f(window).height()}for(i=0;i<f.fn.qtip.interfaces.length;i++){var u=f.fn.qtip.interfaces[i];if(u.status.rendered===true&&(u.options.position.adjust.scroll&&t.type==="scroll"||u.options.position.adjust.resize&&t.type==="resize")){u.updatePosition(t,true)}}},100)});f(document).bind("touchstart.qtip",function(t){if(f(t.target).parents("div.qtip").length===0){f(".qtip[unfocus]").each(function(){var u=f(this).qtip("api");if(f(this).is(":visible")&&!u.status.disabled&&f(t.target).add(u.elements.target).length>1){u.hide(t)}})}});f(document).bind("mousedown.qtip",function(t){if(f(t.target).parents("div.qtip").length===0){f(".qtip[unfocus]").each(function(){var u=f(this).qtip("api");if(f(this).is(":visible")&&!u.status.disabled&&f(t.target).add(u.elements.target).length>1){u.hide(t)}})}})});f.fn.qtip.interfaces=[];f.fn.qtip.log={error:function(){return this}};f.fn.qtip.constants={};f.fn.qtip.defaults={content:{prerender:false,text:false,url:false,data:null,title:{text:false,button:false}},position:{target:false,corner:{target:"bottomRight",tooltip:"topLeft"},adjust:{x:0,y:0,mouse:true,screen:false,scroll:true,resize:true},type:"absolute",container:false},show:{when:{target:false,event:"mouseover"},effect:{type:"fade",length:100},delay:140,solo:false,ready:false},hide:{when:{target:false,event:"mouseout"},effect:{type:"fade",length:100},delay:0,fixed:false},api:{beforeRender:function(){},onRender:function(){},beforePositionUpdate:function(){},onPositionUpdate:function(){},beforeShow:function(){},onShow:function(){},beforeHide:function(){},onHide:function(){},beforeContentUpdate:function(){},onContentUpdate:function(){},beforeContentLoad:function(){},onContentLoad:function(){},beforeTitleUpdate:function(){},onTitleUpdate:function(){},beforeDestroy:function(){},onDestroy:function(){},beforeFocus:function(){},onFocus:function(){}}};f.fn.qtip.styles={defaults:{background:"white",color:"#111",overflow:"hidden",textAlign:"left",width:{min:0,max:250},padding:"5px 9px",border:{width:1,radius:0,color:"#d3d3d3"},tip:{corner:false,color:false,size:{width:13,height:13},opacity:1},title:{background:"#e1e1e1",fontWeight:"bold",padding:"7px 12px"},button:{cursor:"pointer"},classes:{target:"",tip:"qtip-tip",title:"qtip-title",button:"qtip-button",content:"qtip-content",active:"qtip-active"}},cream:{border:{width:3,radius:0,color:"#F9E98E"},title:{background:"#F0DE7D",color:"#A27D35"},background:"#FBF7AA",color:"#A27D35",classes:{tooltip:"qtip-cream"}},light:{border:{width:2,radius:0,color:"#E2E2E2"},title:{background:"#f1f1f1",color:"#454545"},background:"white",color:"#454545",classes:{tooltip:"qtip-light"}},dark:{border:{width:2,radius:0,color:"#303030"},title:{background:"#404040",color:"#f3f3f3"},background:"#505050",color:"#f3f3f3",classes:{tooltip:"qtip-dark"}},red:{border:{width:2,radius:0,color:"#CE6F6F"},title:{background:"#f28279",color:"#9C2F2F"},background:"#F79992",color:"#9C2F2F",classes:{tooltip:"qtip-red"}},green:{border:{width:2,radius:0,color:"#A9DB66"},title:{background:"#b9db8c",color:"#58792E"},background:"#CDE6AC",color:"#58792E",classes:{tooltip:"qtip-green"}},blue:{border:{width:2,radius:0,color:"#ADD9ED"},title:{background:"#D0E9F5",color:"#5E99BD"},background:"#E5F6FE",color:"#4D9FBF",classes:{tooltip:"qtip-blue"}}}})(jQuery);

/**
 * jQuery Plugin: "carouFredSel"
 * http://caroufredsel.frebsite.nl
 * Copyright (c) 2010 Fred Heusschen
 * Dual licensed under the MIT and GPL licenses
 *
 * Version: 3.2.1
 */
eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('(v($){$.1h.1i=v(o){9(I.U==0)y 14(\'3h 3i 2t.\');9(I.U>1){y I.1x(v(){$(I).1i(o)})}I.2u=v(o){9(q o!=\'1a\')o={};9(q o.S==\'C\'){9(o.S<=3j)o.S={u:o.S};A o.S={W:o.S}}A{9(q o.S==\'15\')o.S={X:o.S}}9(q o.u==\'C\')o.u={G:o.u};A 9(q o.u==\'15\')o.u={G:o.u,1K:o.u,1L:o.u};8=$.1M(K,{},$.1h.1i.2L,o);8.P=2M(8.P);8.11=(8.P[0]==0&&8.P[1]==0&&8.P[2]==0&&8.P[3]==0)?Q:K;1j=(8.1j==\'2N\'||8.1j==\'1k\')?\'E\':\'H\';9(8.1j==\'2O\'||8.1j==\'1k\'){8.w=[\'1K\',\'2P\',\'1L\',\'2Q\',\'1k\',\'22\',\'3k\',\'3l\']}A{8.w=[\'1L\',\'2Q\',\'1K\',\'2P\',\'22\',\'1k\',\'3m\',\'3n\'];8.P=[8.P[3],8.P[2],8.P[1],8.P[0]]}9(8[8.w[2]]==\'L\'){8[8.w[2]]=1l(8,J(j))[1];8.u[8.w[2]]=\'L\'}A{9(!8.u[8.w[2]]){8.u[8.w[2]]=J(j)[8.w[3]](K)}}9(!8.u[8.w[0]]){8.u[8.w[0]]=J(j)[8.w[1]](K)}9(8.u.G==\'3o\'){9(q 8[8.w[0]]==\'C\'){8.1y=8[8.w[0]];8[8.w[0]]=1N}A{8.1y=l.1O()[8.w[7]]()}9(q 8.u[8.w[0]]==\'C\'){8.u.G=2v.3p(8.1y/8.u[8.w[0]])}A{2w=K;8.u.G=0}}9(q 8.u.1P!=\'C\')8.u.1P=8.u.G;9(q 8.S.u!=\'C\')8.S.u=8.u.G;9(q 8.S.W!=\'C\')8.S.W=3q;8.L=1Q(8.L,Q,K);8.H=1Q(8.H);8.E=1Q(8.E);8.T=1Q(8.T,K);8.L=$.1M({},8.S,8.L);8.H=$.1M({},8.S,8.H);8.E=$.1M({},8.S,8.E);8.T=$.1M({},8.S,8.T);9(q 8.T.23!=\'Z\')8.T.23=Q;9(q 8.T.2x!=\'v\')8.T.2x=$.1h.1i.2R;9(q 8.L.V!=\'Z\')8.L.V=K;9(q 8.L.1R!=\'Z\')8.L.1R=K;9(q 8.L.2y!=\'C\')8.L.2y=0;9(q 8.L.24!=\'C\')8.L.24=(8.L.W<10)?3r:8.L.W*5};I.2S=v(){l.O({25:\'3s\',3t:\'3u\'});j.z(\'2T\',{1K:j.O(\'1K\'),1L:j.O(\'1L\'),25:j.O(\'25\'),22:j.O(\'22\'),1k:j.O(\'1k\')}).O({25:\'3v\'});9(8.11){J(j).1x(v(){D m=1S($(I).O(8.w[6]));9(26(m))m=0;$(I).z(\'Y\',m)})}27(8,F)};I.2U=v(){j.16(\'1e\',v(e,g){9(q g!=\'Z\')g=Q;9(g)1m=K;9(28!=1N){3w(28)}9(29!=1N){3x(29)}});j.16(\'V\',v(e,d,f,g){j.B(\'1e\');9(8.L.V){9(q g!=\'Z\'){9(q f==\'Z\')g=f;A 9(q d==\'Z\')g=d;A g=Q}9(q f!=\'C\'){9(q d==\'C\')f=d;A f=0}9(d!=\'H\'&&d!=\'E\')d=1j;9(g)1m=Q;9(1m)y;28=3y(v(){9(j.1b(\':1z\')){j.B(\'V\',d)}A{2a=0;j.B(d,8.L)}},8.L.24+f-2a);9(8.L.1A===\'3z\'){29=3A(v(){2a+=2V},2V)}}});9(2w){j.16(\'H\',v(e,b,c){9(j.1b(\':1z\'))y;9(1m)y;D d=J(j),1n=0,x=0;9(q b==\'C\')c=b;9(q c!=\'C\'){1T(D a=d.U-1;a>=0;a--){1f=d.18(\':2z(\'+a+\')\')[8.w[1]](K);9(1n+1f>8.1y)2A;1n+=1f;x++}c=x}1T(D a=d.U-c;a<d.U;a++){1f=d.18(\':2z(\'+a+\')\')[8.w[1]](K);9(1n+1f>8.1y)2A;1n+=1f;9(a==d.U-1)a=0;x++};8.u.G=x;j.B(\'2B\',[b,c])});j.16(\'E\',v(e,b,c){9(j.1b(\':1z\'))y;9(1m)y;D d=J(j),1n=0,x=0;9(q b==\'C\')c=b;9(q c!=\'C\')c=8.u.G;1T(D a=c;a<d.U;a++){1f=d.18(\':2z(\'+a+\')\')[8.w[1]](K);9(1n+1f>8.1y)2A;1n+=1f;9(a==d.U-1)a=0;x++};8.u.G=x;j.B(\'2C\',[b,c])}).B(\'E\',{W:0})}A{j.16(\'H\',v(e,a,b){j.B(\'2B\',[a,b])});j.16(\'E\',v(e,a,b){j.B(\'2C\',[a,b])})}j.16(\'2B\',v(e,b,c){9(j.1b(\':1z\'))y;9(1m)y;9(8.u.1P>=F)y 14(\'1t 2D u: 1U 1V\');9(q b==\'C\')c=b;9(q b!=\'1a\')b=8.H;9(q c!=\'C\')c=b.u;9(q c!=\'C\')y 14(\'1t a 2b C: 1U 1V\');9(!8.1u){D d=F-M;9(d-c<0){c=d}9(M==0){c=0}}M+=c;9(M>=F)M-=F;9(!8.1u){9(M==0&&c!=0&&8.H.2c){8.H.2c()}9(8.2d){9(c==0){j.B(\'E\',F-8.u.G);y Q}}A{9(M==0&&8.H.R)8.H.R.2e(\'1W\');9(8.E.R)8.E.R.2E(\'1W\')}}9(c==0){y Q}J(j,\':2f(\'+(F-c-1)+\')\').3B(j);9(F<8.u.G+c)J(j,\':1o(\'+((8.u.G+c)-F)+\')\').2W(K).2F(j);D f=2G(j,8,c),1p=J(j,\':1v(\'+(c-1)+\')\'),17=f[1].18(\':1B\'),1c=f[0].18(\':1B\');9(8.11)17.O(8.w[6],17.z(\'Y\'));D g=1l(8,J(j,\':1o(\'+c+\')\')),1q=2g(1l(8,f[0],K),8);9(8.11)17.O(8.w[6],17.z(\'Y\')+8.P[1]);D h={},2H={},1C={},N=b.W;9(N==\'L\')N=8.S.W/8.S.u*c;A 9(N<=0)N=0;A 9(N<10)N=g[0]/N;9(b.2h)b.2h(f[1],f[0],1q,N);9(8.11){D i=8.P[3];1C[8.w[6]]=1p.z(\'Y\');2H[8.w[6]]=1c.z(\'Y\')+8.P[1];1p.O(8.w[6],1p.z(\'Y\')+8.P[3]);1p.1D().1r(1C,{W:N,X:b.X});1c.1D().1r(2H,{W:N,X:b.X})}A{D i=0}h[8.w[4]]=i;9((q 8[8.w[0]]!=\'C\'&&q 8.u[8.w[0]]!=\'C\')||(q 8[8.w[2]]!=\'C\'&&q 8.u[8.w[2]]!=\'C\')){l.1D().1r(1q,{W:N,X:b.X})}j.z(\'1E\',c).z(\'1F\',b).z(\'2i\',f[1]).z(\'2j\',f[0]).z(\'2k\',1q).O(8.w[4],-g[0]).1r(h,{W:N,X:b.X,2X:v(){9(j.z(\'1F\').2l){j.z(\'1F\').2l(j.z(\'2i\'),j.z(\'2j\'),j.z(\'2k\'))}9(F<8.u.G+j.z(\'1E\')){J(j,\':2f(\'+(F-1)+\')\').1X()}D a=J(j,\':1v(\'+(8.u.G+j.z(\'1E\')-1)+\')\');9(8.11){a.O(8.w[6],a.z(\'Y\'))}}});j.B(\'1w\').B(\'V\',N)});j.16(\'2C\',v(e,c,d){9(j.1b(\':1z\'))y;9(1m)y;9(8.u.1P>=F)y 14(\'1t 2D u: 1U 1V\');9(q c==\'C\')d=c;9(q c!=\'1a\')c=8.E;9(q d!=\'C\')d=c.u;9(q d!=\'C\')y 14(\'1t a 2b C: 1U 1V\');9(!8.1u){9(M==0){9(d>F-8.u.G){d=F-8.u.G}}A{9(M-d<8.u.G){d=M-8.u.G}}}M-=d;9(M<0)M+=F;9(!8.1u){9(M==8.u.G&&d!=0&&8.E.2c){8.E.2c()}9(8.2d){9(d==0){j.B(\'H\',F-8.u.G);y Q}}A{9(M==8.u.G&&8.E.R)8.E.R.2e(\'1W\');9(8.H.R)8.H.R.2E(\'1W\')}}9(d==0){y Q}9(F<8.u.G+d)J(j,\':1o(\'+((8.u.G+d)-F)+\')\').2W(K).2F(j);D f=2G(j,8,d),1p=J(j,\':1v(\'+(d-1)+\')\'),17=f[0].18(\':1B\'),1c=f[1].18(\':1B\');9(8.11){17.O(8.w[6],17.z(\'Y\'));1c.O(8.w[6],1c.z(\'Y\'))}D g=1l(8,J(j,\':1o(\'+d+\')\')),1q=2g(1l(8,f[1],K),8);9(8.11){17.O(8.w[6],17.z(\'Y\')+8.P[1]);1c.O(8.w[6],1c.z(\'Y\')+8.P[1])}D h={},2I={},1C={},N=c.W;9(N==\'L\')N=8.S.W/8.S.u*d;A 9(N<=0)N=0;A 9(N<10)N=g[0]/N;9(c.2h)c.2h(f[0],f[1],1q,N);h[8.w[4]]=-g[0];9(8.11){2I[8.w[6]]=17.z(\'Y\');1C[8.w[6]]=1p.z(\'Y\')+8.P[3];1c.O(8.w[6],1c.z(\'Y\')+8.P[1]);17.1D().1r(2I,{W:N,X:c.X});1p.1D().1r(1C,{W:N,X:c.X})}9((q 8[8.w[0]]!=\'C\'&&q 8.u[8.w[0]]!=\'C\')||(q 8[8.w[2]]!=\'C\'&&q 8.u[8.w[2]]!=\'C\')){l.1D().1r(1q,{W:N,X:c.X})}j.z(\'1E\',d).z(\'1F\',c).z(\'2i\',f[0]).z(\'2j\',f[1]).z(\'2k\',1q).1r(h,{W:N,X:c.X,2X:v(){9(j.z(\'1F\').2l){j.z(\'1F\').2l(j.z(\'2i\'),j.z(\'2j\'),j.z(\'2k\'))}9(F<8.u.G+j.z(\'1E\')){J(j,\':2f(\'+(F-1)+\')\').1X()}D a=(8.11)?8.P[3]:0;j.O(8.w[4],a);D b=J(j,\':1o(\'+j.z(\'1E\')+\')\').2F(j).18(\':1B\');9(8.11){b.O(8.w[6],b.z(\'Y\'))}}});j.B(\'1w\').B(\'V\',N)});j.16(\'1G\',v(e,a,b,c,d){9(j.1b(\':1z\'))y Q;a=2m(a,b,c,M,F,j);9(a==0)y Q;9(q d!=\'1a\')d=Q;9(8.1u){9(a<F/2)j.B(\'E\',[d,a]);A j.B(\'H\',[d,F-a])}A{9(M==0||M>a)j.B(\'E\',[d,a]);A j.B(\'H\',[d,F-a])}}).16(\'2Y\',v(e,a,b,c,d){9(q a==\'1a\'&&q a.1Y==\'12\')a=$(a);9(q a==\'15\')a=$(a);9(q a!=\'1a\'||q a.1Y==\'12\'||a.U==0)y 14(\'1t a 2b 1a.\');9(q b==\'12\'||b==\'2Z\'){j.2J(a)}A{b=2m(b,d,c,M,F,j);D f=J(j,\':1v(\'+b+\')\');9(f.U){9(b<=M)M+=a.U;f.3C(a)}A{j.2J(a)}}F=J(j).U;1H(\'\',\'.2n\',j);1Z(j,8);27(8,F);j.B(\'1w\',K)}).16(\'30\',v(e,a,b,c){9(q a==\'12\'||a==\'2Z\'){J(j,\':1B\').1X()}A{a=2m(a,c,b,M,F,j);D d=J(j,\':1v(\'+a+\')\');9(d.U){9(a<M)M-=d.U;d.1X()}}F=J(j).U;1H(\'\',\'.2n\',j);1Z(j,8);27(8,F);j.B(\'1w\',K)}).16(\'1w\',v(e,b){9(!8.T.13)y Q;9(q b==\'Z\'&&b){J(8.T.13).1X();1T(D a=0;a<2v.3D(F/8.u.G);a++){8.T.13.2J(8.T.2x(a+1))}J(8.T.13).19(\'1I\').1x(v(a){$(I).1I(v(e){e.1g();j.B(\'1G\',[a*8.u.G,0,K,8.T])})})}D c=(M==0)?0:2v.3E((F-M)/8.u.G);J(8.T.13).2E(\'2t\').18(\':1v(\'+c+\')\').2e(\'2t\')})};I.31=v(){9(8.L.1A&&8.L.V){l.2o(v(){j.B(\'1e\')},v(){j.B(\'V\')})}9(8.H.R){8.H.R.1I(v(e){j.B(\'H\');e.1g()});9(8.H.1A&&8.L.V){8.H.R.2o(v(){j.B(\'1e\')},v(){j.B(\'V\')})}9(!8.1u&&!8.2d){8.H.R.2e(\'1W\')}}9($.1h.1d){9(8.H.1d){l.1d(v(e,a){9(a>0){e.1g();2p=(q 8.H.1d==\'C\')?8.H.1d:\'\';j.B(\'H\',2p)}})}9(8.E.1d){l.1d(v(e,a){9(a<0){e.1g();2p=(q 8.E.1d==\'C\')?8.E.1d:\'\';j.B(\'E\',2p)}})}}9(8.E.R){8.E.R.1I(v(e){e.1g();j.B(\'E\')});9(8.E.1A&&8.L.V){8.E.R.2o(v(){j.B(\'1e\')},v(){j.B(\'V\')})}}9(8.T.13){j.B(\'1w\',K);9(8.T.1A&&8.L.V){8.T.13.2o(v(){j.B(\'1e\')},v(){j.B(\'V\')})}}9(8.E.1s||8.H.1s){$(32).33(v(e){D k=e.34;9(k==8.E.1s){e.1g();j.B(\'E\')}9(k==8.H.1s){e.1g();j.B(\'H\')}})}9(8.T.23){$(32).33(v(e){D k=e.34;9(k>=49&&k<3F){k=(k-49)*8.u.G;9(k<=F){e.1g();j.B(\'1G\',[k,0,K,8.T])}}})}9(8.L.V){j.B(\'V\',8.L.2y);9($.1h.1R&&8.L.1R){j.1R(\'1e\',\'V\')}}};I.35=v(){j.B(\'1e\').O(j.z(\'2T\')).19(\'1e\').19(\'V\').19(\'H\').19(\'E\').19(\'3G\').19(\'1G\').19(\'2Y\').19(\'30\').19(\'1w\');l.3H(j);y I};I.3I=v(a,b){9(q a==\'12\')y 8;9(q b==\'12\'){D r=36(\'8.\'+a);9(q r==\'12\')r=\'\';y r}36(\'8.\'+a+\' = b\');I.2u(8);1Z(j,8);y I};I.1H=v(a,b){1H(a,b,j)};I.3J=v(){9(M==0){y 0}y F-M};D j=$(I);9($(I).1O().1b(\'.3a\')){D l=j.1O();I.35()}D l=$(I).3K(\'<3L 3M="3a" />\').1O(),8={},F=J(j).U,M=0,28=1N,29=1N,2a=0,1m=Q,1j=\'E\',2w=Q;I.2u(o);I.2S();I.2U();I.31();1H(\'\',\'.2n\',j);1Z(j,8);9(8.u.20!==0&&8.u.20!==Q){D s=8.u.20;9(8.u.20===K){s=2q.3N.3b;9(!s.U)s=0}j.B(\'1G\',[s,0,K,{W:0}])}y I};$.1h.1i.2L={2d:K,1u:K,1j:\'1k\',P:0,u:{G:5,20:0},S:{X:\'3O\',1A:Q,1d:Q}};$.1h.1i.2R=v(a){y\'<a 3P="#"><3c>\'+a+\'</3c></a>\'};v 1H(a,b,c){9(q a==\'12\'||a.U==0)a=$(\'3Q\');A 9(q a==\'15\')a=$(a);9(q a!=\'1a\')y Q;9(q b==\'12\')b=\'\';a.3R(\'a\'+b).1x(v(){D h=I.3b||\'\';9(h.U>0&&J(c).3d($(h))!=-1){$(I).19(\'1I\').1I(v(e){e.1g();c.B(\'1G\',h)})}})}v 27(o,t){9(o.u.1P>=t){14(\'1t 2D u: 1U 1V\');D f=\'3S\'}A{D f=\'3T\'}9(o.H.R)o.H.R[f]();9(o.E.R)o.E.R[f]();9(o.T.13)o.T.13[f]()}v 2K(k){9(k==\'2O\')y 39;9(k==\'1k\')y 37;9(k==\'2N\')y 38;9(k==\'3U\')y 40;y-1};v 1Q(a,b,c){9(q b!=\'Z\')b=Q;9(q c!=\'Z\')c=Q;9(q a==\'12\')a={};9(q a==\'15\'){D d=2K(a);9(d==-1)a=$(a);A a=d}9(b){9(q a.1Y!=\'12\')a={13:a};9(q 3V==\'Z\')a={23:a};9(q a.13==\'15\')a.13=$(a.13)}A 9(c){9(q a==\'Z\')a={V:a};9(q a==\'C\')a={24:a}}A{9(q a.1Y!=\'12\')a={R:a};9(q a==\'C\')a={1s:a};9(q a.R==\'15\')a.R=$(a.R);9(q a.1s==\'15\')a.1s=2K(a.1s)}y a};v J(a,f){9(q f!=\'15\')f=\'\';y $(\'> *\'+f,a)};v 2G(c,o,n){D a=J(c,\':1o(\'+o.u.G+\')\'),3e=J(c,\':1o(\'+(o.u.G+n)+\'):2f(\'+(n-1)+\')\');y[a,3e]};v 2m(a,b,c,d,e,f){9(q a==\'15\'){9(26(a))a=$(a);A a=1S(a)}9(q a==\'1a\'){9(q a.1Y==\'12\')a=$(a);a=J(f).3d(a);9(a==-1)a=0;9(q c!=\'Z\')c=Q}A{9(q c!=\'Z\')c=K}9(26(a))a=0;A a=1S(a);9(26(b))b=0;A b=1S(b);9(c){a+=d}a+=b;9(e>0){3f(a>=e){a-=e}3f(a<0){a+=e}}y a};v 1l(o,a,b){9(q b!=\'Z\')b=Q;D c=o.w,21=0,1J=0;9(b&&q o[c[0]]==\'C\')21+=o[c[0]];A 9(q o.u[c[0]]==\'C\')21+=o.u[c[0]]*a.U;A{a.1x(v(){21+=$(I)[c[1]](K)})}9(b&&q o[c[2]]==\'C\')1J+=o[c[2]];A 9(q o.u[c[2]]==\'C\')1J+=o.u[c[2]];A{a.1x(v(){D m=$(I)[c[3]](K);9(1J<m)1J=m})}y[21,1J]};v 2g(a,o){D b=(o.11)?o.P:[0,0,0,0];D c={};c[o.w[0]]=a[0]+b[1]+b[3];c[o.w[2]]=a[1]+b[0]+b[2];y c};v 1Z(a,o){D b=a.1O(),$i=J(a),$l=$i.18(\':1v(\'+(o.u.G-1)+\')\'),1b=1l(o,$i,Q);b.O(2g(1l(o,$i.18(\':1o(\'+o.u.G+\')\'),K),o));9(o.11){$l.O(o.w[6],$l.z(\'Y\')+o.P[1]);a.O(o.w[5],o.P[0]);a.O(o.w[4],o.P[3])}a.O(o.w[0],1b[0]*2);a.O(o.w[2],1b[1])};v 2M(p){9(q p==\'C\')p=[p];A 9(q p==\'15\')p=p.3g(\'3W\').3X(\'\').3g(\' \');9(q p!=\'1a\'){14(\'1t a 2b 3Y, P 3Z 41 "0".\');p=[0]}1T(i 42 p){p[i]=1S(p[i])}43(p.U){2r 0:y[0,0,0,0];2r 1:y[p[0],p[0],p[0],p[0]];2r 2:y[p[0],p[1],p[0],p[1]];2r 3:y[p[0],p[1],p[2],p[1]];44:y p}};v 14(m){9(q m==\'15\')m=\'1i: \'+m;9(2q.2s&&2q.2s.14)2q.2s.14(m);A 45{2s.14(m)}46(47){}y Q};$.1h.2n=v(o){I.1i(o)}})(48);',62,258,'||||||||opts|if|||||||||||||||||typeof||||items|function|dimentions||return|data|else|trigger|number|var|next|totalItems|visible|prev|this|getItems|true|auto|firstItem|a_dur|css|padding|false|button|scroll|pagination|length|play|duration|easing|cfs_origCssMargin|boolean||usePadding|undefined|container|log|string|bind|l_old|filter|unbind|object|is|l_new|mousewheel|pause|current|preventDefault|fn|carouFredSel|direction|left|getSizes|pausedGlobal|total|lt|l_cur|w_siz|animate|key|Not|circular|nth|updatePageStatus|each|maxDimention|animated|pauseOnHover|last|a_cur|stop|cfs_numItems|cfs_slideObj|slideTo|link_anchors|click|s2|width|height|extend|null|parent|minimum|getNaviObject|nap|parseInt|for|not|scrolling|disabled|remove|jquery|setSizes|start|s1|top|keys|pauseDuration|position|isNaN|showNavi|autoTimeout|autoInterval|pauseTimePassed|valid|onEnd|infinite|addClass|gt|mapWrapperSizes|onBefore|cfs_oldItems|cfs_newItems|cfs_wrapSize|onAfter|getItemIndex|caroufredsel|hover|num|window|case|console|selected|init|Math|varnumvisitem|anchorBuilder|delay|eq|break|scrollPrev|scrollNext|enough|removeClass|appendTo|getCurrentItems|a_new|a_old|append|getKeyCode|defaults|getPadding|up|right|outerWidth|outerHeight|pageAnchorBuilder|build|cfs_origCss|bind_events|100|clone|complete|insertItem|end|removeItem|bind_buttons|document|keyup|keyCode|destroy|eval||||caroufredsel_wrapper|hash|span|index|ni|while|split|No|element|50|marginRight|innerWidth|marginBottom|innerHeight|variable|floor|500|2500|relative|overflow|hidden|absolute|clearTimeout|clearInterval|setTimeout|resume|setInterval|prependTo|before|ceil|round|58|scrollTo|replaceWith|configuration|current_position|wrap|div|class|location|swing|href|body|find|hide|show|down|Object|px|join|value|set||to|in|switch|default|try|catch|err|jQuery|'.split('|'),0,{}))

/**
 * jQuery Plugin: "easing"
 * http://gsgd.co.uk/sandbox/jquery/easing/
 * Copyright © 2008 George McGinley Smith
 * Open source under the BSD License.
 */
jQuery.easing['jswing']=jQuery.easing['swing'];jQuery.extend(jQuery.easing,{def:'easeOutQuad',swing:function(x,t,b,c,d){return jQuery.easing[jQuery.easing.def](x,t,b,c,d);},easeInQuad:function(x,t,b,c,d){return c*(t/=d)*t+b;},easeOutQuad:function(x,t,b,c,d){return-c*(t/=d)*(t-2)+b;},easeInOutQuad:function(x,t,b,c,d){if((t/=d/2)<1)return c/2*t*t+b;return-c/2*((--t)*(t-2)-1)+b;},easeInCubic:function(x,t,b,c,d){return c*(t/=d)*t*t+b;},easeOutCubic:function(x,t,b,c,d){return c*((t=t/d-1)*t*t+1)+b;},easeInOutCubic:function(x,t,b,c,d){if((t/=d/2)<1)return c/2*t*t*t+b;return c/2*((t-=2)*t*t+2)+b;},easeInQuart:function(x,t,b,c,d){return c*(t/=d)*t*t*t+b;},easeOutQuart:function(x,t,b,c,d){return-c*((t=t/d-1)*t*t*t-1)+b;},easeInOutQuart:function(x,t,b,c,d){if((t/=d/2)<1)return c/2*t*t*t*t+b;return-c/2*((t-=2)*t*t*t-2)+b;},easeInQuint:function(x,t,b,c,d){return c*(t/=d)*t*t*t*t+b;},easeOutQuint:function(x,t,b,c,d){return c*((t=t/d-1)*t*t*t*t+1)+b;},easeInOutQuint:function(x,t,b,c,d){if((t/=d/2)<1)return c/2*t*t*t*t*t+b;return c/2*((t-=2)*t*t*t*t+2)+b;},easeInSine:function(x,t,b,c,d){return-c*Math.cos(t/d*(Math.PI/2))+c+b;},easeOutSine:function(x,t,b,c,d){return c*Math.sin(t/d*(Math.PI/2))+b;},easeInOutSine:function(x,t,b,c,d){return-c/2*(Math.cos(Math.PI*t/d)-1)+b;},easeInExpo:function(x,t,b,c,d){return(t==0)?b:c*Math.pow(2,10*(t/d-1))+b;},easeOutExpo:function(x,t,b,c,d){return(t==d)?b+c:c*(-Math.pow(2,-10*t/d)+1)+b;},easeInOutExpo:function(x,t,b,c,d){if(t==0)return b;if(t==d)return b+c;if((t/=d/2)<1)return c/2*Math.pow(2,10*(t-1))+b;return c/2*(-Math.pow(2,-10*--t)+2)+b;},easeInCirc:function(x,t,b,c,d){return-c*(Math.sqrt(1-(t/=d)*t)-1)+b;},easeOutCirc:function(x,t,b,c,d){return c*Math.sqrt(1-(t=t/d-1)*t)+b;},easeInOutCirc:function(x,t,b,c,d){if((t/=d/2)<1)return-c/2*(Math.sqrt(1-t*t)-1)+b;return c/2*(Math.sqrt(1-(t-=2)*t)+1)+b;},easeInElastic:function(x,t,b,c,d){var s=1.70158;var p=0;var a=c;if(t==0)return b;if((t/=d)==1)return b+c;if(!p)p=d*.3;if(a<Math.abs(c)){a=c;var s=p/4;}
else var s=p/(2*Math.PI)*Math.asin(c/a);return-(a*Math.pow(2,10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p))+b;},easeOutElastic:function(x,t,b,c,d){var s=1.70158;var p=0;var a=c;if(t==0)return b;if((t/=d)==1)return b+c;if(!p)p=d*.3;if(a<Math.abs(c)){a=c;var s=p/4;}
else var s=p/(2*Math.PI)*Math.asin(c/a);return a*Math.pow(2,-10*t)*Math.sin((t*d-s)*(2*Math.PI)/p)+c+b;},easeInOutElastic:function(x,t,b,c,d){var s=1.70158;var p=0;var a=c;if(t==0)return b;if((t/=d/2)==2)return b+c;if(!p)p=d*(.3*1.5);if(a<Math.abs(c)){a=c;var s=p/4;}
else var s=p/(2*Math.PI)*Math.asin(c/a);if(t<1)return-.5*(a*Math.pow(2,10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p))+b;return a*Math.pow(2,-10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p)*.5+c+b;},easeInBack:function(x,t,b,c,d,s){if(s==undefined)s=1.70158;return c*(t/=d)*t*((s+1)*t-s)+b;},easeOutBack:function(x,t,b,c,d,s){if(s==undefined)s=1.70158;return c*((t=t/d-1)*t*((s+1)*t+s)+1)+b;},easeInOutBack:function(x,t,b,c,d,s){if(s==undefined)s=1.70158;if((t/=d/2)<1)return c/2*(t*t*(((s*=(1.525))+1)*t-s))+b;return c/2*((t-=2)*t*(((s*=(1.525))+1)*t+s)+2)+b;},easeInBounce:function(x,t,b,c,d){return c-jQuery.easing.easeOutBounce(x,d-t,0,c,d)+b;},easeOutBounce:function(x,t,b,c,d){if((t/=d)<(1/2.75)){return c*(7.5625*t*t)+b;}else if(t<(2/2.75)){return c*(7.5625*(t-=(1.5/2.75))*t+.75)+b;}else if(t<(2.5/2.75)){return c*(7.5625*(t-=(2.25/2.75))*t+.9375)+b;}else{return c*(7.5625*(t-=(2.625/2.75))*t+.984375)+b;}},easeInOutBounce:function(x,t,b,c,d){if(t<d/2)return jQuery.easing.easeInBounce(x,t*2,0,c,d)*.5+b;return jQuery.easing.easeOutBounce(x,t*2-d,0,c,d)*.5+c*.5+b;}});

/**
 * jQuery Plugin: "syncHeight"
 * http://blog.ginader.de/dev/syncheight/
 * Copyright (c) 2007, Dirk Ginader (ginader.de), Dirk Jesse (yaml.de)
 * Dual licensed under the MIT and GPL licenses
 *
 * Version: 1.0
 */
(function($){$.fn.syncHeight=function(settings){var max=0;var browser_id=0;var property=[['min-height','0px'],['height','1%']];if($.browser.msie&&$.browser.version<9){browser_id=1;}$(this).each(function(){$(this).css(property[browser_id][0],property[browser_id][1]);if($.browser.msie&&$.browser.version<9){var val=$(this).outerHeight();}else var val=$(this).height();if(val>max){max=val;}});$(this).each(function(){$(this).css(property[browser_id][0],max+'px');});return this;};})(jQuery);

/**
 * jQuery Plugin: "Accordion menu"
 * http://www.i-marco.nl/weblog/archive/2010/02/27/yup_yet_another_jquery_accordi
 * Copyright 2007-2010 by Marco van Hylckama Vlieg
 * Dual licensed under the MIT and GPL licenses
 *
 */
jQuery.fn.initMenu=function(){return this.each(function(){var theMenu=$(this).get(0);$('.acitem',this).hide();$('li.expand > .acitem',this).show();$('li.expand > .acitem',this).prev().addClass('active');$('li a',this).click(function(e){e.stopImmediatePropagation();var theElement=$(this).next();var parent=this.parentNode.parentNode;if($(parent).hasClass('noaccordion')){if(theElement[0]===undefined){window.location.href=this.href;}$(theElement).slideToggle('fast',function(){if($(this).is(':visible')){$(this).prev().addClass('active');}else{$(this).prev().removeClass('active');}});return false;}else{if(theElement.hasClass('acitem')&&theElement.is(':visible')){if($(parent).hasClass('collapsible')){$('.acitem:visible',parent).first().slideUp('fast',function(){$(this).prev().removeClass('active');});return false;}return false;}if(theElement.hasClass('acitem')&&!theElement.is(':visible')){$('.acitem:visible',parent).first().slideUp('fast',function(){$(this).prev().removeClass('active');});theElement.slideDown('fast',function(){$(this).prev().addClass('active');});return false;}}});});};

/**
 * jQuery Plugin: "Collapser"
 * http://www.aakashweb.com/jquery-plugins/collapser/
 * Copyright 2010, Aakash Chakravarthy
 * Released under the MIT License.
 */
(function($){$.fn.collapser=function(options,beforeCallback,afterCallback){var defaults={target:'next',targetOnly:null,effect:'slide',changeText:true,expandHtml:'Expand',collapseHtml:'Collapse',expandClass:'',collapseClass:''};var options=$.extend(defaults,options);var expHtml,collHtml,effectShow,effectHide;if(options.effect=='slide'){effectShow='slideDown';effectHide='slideUp';}else{effectShow='fadeIn';effectHide='fadeOut';}if(options.changeText==true){expHtml=options.expandHtml;collHtml=options.collapseHtml;}function callBeforeCallback(obj){if(beforeCallback!==undefined){beforeCallback.apply(obj);}}function callAfterCallback(obj){if(afterCallback!==undefined){afterCallback.apply(obj);}}function hideElement(obj,method){callBeforeCallback(obj);if(method==1){obj[options.target](options.targetOnly)[effectHide]('fast');obj.html(expHtml);obj.removeClass(options.collapseClass);obj.addClass(options.expandClass);}else{$(document).find(options.target)[effectHide]('fast');obj.html(expHtml);obj.removeClass(options.collapseClass);obj.addClass(options.expandClass);}callAfterCallback(obj);}function showElement(obj,method){callBeforeCallback(obj)
if(method==1){obj[options.target](options.targetOnly)[effectShow]('fast');obj.html(collHtml);obj.removeClass(options.expandClass);obj.addClass(options.collapseClass);}else{$(document).find(options.target)[effectShow]('fast');obj.html(collHtml);obj.removeClass(options.expandClass);obj.addClass(options.collapseClass);}callAfterCallback(obj);}function toggleElement(obj,method){if(method==1){if(obj[options.target](options.targetOnly).is(':visible')){hideElement(obj,1);}else{showElement(obj,1);}}else{if($(document).find(options.target).is(':visible')){hideElement(obj,2);}else{showElement(obj,2);}}}return this.each(function(){if($.fn[options.target]&&$(this)[options.target]()){$(this).toggle(function(){toggleElement($(this),1);},function(){toggleElement($(this),1);});}else{$(this).toggle(function(){toggleElement($(this),2);},function(){toggleElement($(this),2);});}if($.fn[options.target]&&$(this)[options.target]()){if($(this)[options.target]().is(':hidden')){$(this).html(expHtml);$(this).removeClass(options.collapseClass);$(this).addClass(options.expandClass);}else{$(this).html(collHtml);$(this).removeClass(options.expandClass);$(this).addClass(options.collapseClass);}}else{if($(document).find(options.target).is(':hidden')){$(this).html(expHtml);}else{$(this).html(collHtml);}}});};})(jQuery);

/**
 * jQuery Plugin: "Tabs"
 * http://flowplayer.org/tools/tabs/
 *
 */
(function(c){function p(d,b,a){var e=this,l=d.add(this),h=d.find(a.tabs),i=b.jquery?b:d.children(b),j;h.length||(h=d.children());i.length||(i=d.parent().find(b));i.length||(i=c(b));c.extend(this,{click:function(f,g){var k=h.eq(f);if(typeof f=="string"&&f.replace("#","")){k=h.filter("[href*="+f.replace("#","")+"]");f=Math.max(h.index(k),0)}if(a.rotate){var n=h.length-1;if(f<0)return e.click(n,g);if(f>n)return e.click(0,g)}if(!k.length){if(j>=0)return e;f=a.initialIndex;k=h.eq(f)}if(f===j)return e;
g=g||c.Event();g.type="onBeforeClick";l.trigger(g,[f]);if(!g.isDefaultPrevented()){o[a.effect].call(e,f,function(){g.type="onClick";l.trigger(g,[f])});j=f;h.removeClass(a.current);k.addClass(a.current);return e}},getConf:function(){return a},getTabs:function(){return h},getPanes:function(){return i},getCurrentPane:function(){return i.eq(j)},getCurrentTab:function(){return h.eq(j)},getIndex:function(){return j},next:function(){return e.click(j+1)},prev:function(){return e.click(j-1)},destroy:function(){h.unbind(a.event).removeClass(a.current);
i.find("a[href^=#]").unbind("click.T");return e}});c.each("onBeforeClick,onClick".split(","),function(f,g){c.isFunction(a[g])&&c(e).bind(g,a[g]);e[g]=function(k){k&&c(e).bind(g,k);return e}});if(a.history&&c.fn.history){c.tools.history.init(h);a.event="history"}h.each(function(f){c(this).bind(a.event,function(g){e.click(f,g);return g.preventDefault()})});i.find("a[href^=#]").bind("click.T",function(f){e.click(c(this).attr("href"),f)});if(location.hash&&a.tabs=="a"&&d.find("[href="+location.hash+"]").length)e.click(location.hash);
else if(a.initialIndex===0||a.initialIndex>0)e.click(a.initialIndex)}c.tools=c.tools||{version:"1.2.5"};c.tools.tabs={conf:{tabs:"a",current:"current",onBeforeClick:null,onClick:null,effect:"default",initialIndex:0,event:"click",rotate:false,history:false},addEffect:function(d,b){o[d]=b}};var o={"default":function(d,b){this.getPanes().hide().eq(d).show();b.call()},fade:function(d,b){var a=this.getConf(),e=a.fadeOutSpeed,l=this.getPanes();e?l.fadeOut(e):l.hide();l.eq(d).fadeIn(a.fadeInSpeed,b)},slide:function(d,
b){this.getPanes().slideUp(200);this.getPanes().eq(d).slideDown(400,b)},ajax:function(d,b){this.getPanes().eq(0).load(this.getTabs().eq(d).attr("href"),b)}},m;c.tools.tabs.addEffect("horizontal",function(d,b){m||(m=this.getPanes().eq(0).width());this.getCurrentPane().animate({width:0},function(){c(this).hide()});this.getPanes().eq(d).animate({width:m},function(){c(this).show();b.call()})});c.fn.tabs=function(d,b){var a=this.data("tabs");if(a){a.destroy();this.removeData("tabs")}if(c.isFunction(b))b=
{onBeforeClick:b};b=c.extend({},c.tools.tabs.conf,b);this.each(function(){a=new p(c(this),d,b);c(this).data("tabs",a)});return b.api?a:this}})(jQuery);

/**
 * jQuery Plugin: "fixedTableHeader"
 * Copyright (c) 2009 Mustafa OZCAN 
 * http://www.mustafaozcan.net/en/post/2009/10/04/jQuery-Fixed-Table-Header-Plugin-10.aspx
 */
jQuery.fn.fixedtableheader = function(options) { var settings = jQuery.extend({ headerrowsize: 1, highlightrow: false, highlightclass: "highlight" }, options); this.each(function(i) { var $tbl = $(this); var $tblhfixed = $tbl.find("tr:lt(" + settings.headerrowsize + ")"); var headerelement = "th"; if ($tblhfixed.find(headerelement).length == 0) headerelement = "td"; if ($tblhfixed.find(headerelement).length > 0) { $tblhfixed.find(headerelement).each(function() { $(this).css("width", $(this).width()); }); var $clonedTable = $tbl.clone().empty(); var tblwidth = GetTblWidth($tbl); $clonedTable.attr("id", "fixedtableheader" + i).css({ "position": "fixed", "top": "0", "left": $tbl.offset().left }).append($tblhfixed.clone()).width(tblwidth).hide().appendTo($("body")); if (settings.highlightrow) $("tr:gt(" + (settings.headerrowsize - 1) + ")", $tbl).hover(function() { $(this).addClass(settings.highlightclass); }, function() { $(this).removeClass(settings.highlightclass); }); $(window).scroll(function() { if (jQuery.browser.msie && jQuery.browser.version == "6.0") $clonedTable.css({ "position": "absolute", "top": $(window).scrollTop(), "left": $tbl.offset().left }); else $clonedTable.css({ "position": "fixed", "top": "0", "left": $tbl.offset().left - $(window).scrollLeft() }); var sctop = $(window).scrollTop(); var elmtop = $tblhfixed.offset().top; if (sctop > elmtop && sctop <= (elmtop + $tbl.height() - $tblhfixed.height())) $clonedTable.show(); else $clonedTable.hide(); }); $(window).resize(function() { if ($clonedTable.outerWidth() != $tbl.outerWidth()) { $tblhfixed.find(headerelement).each(function(index) { var w = $(this).width(); $(this).css("width", w); $clonedTable.find(headerelement).eq(index).css("width", w); }); $clonedTable.width($tbl.outerWidth()); } $clonedTable.css("left", $tbl.offset().left); }); } }); function GetTblWidth($tbl) { var tblwidth = $tbl.outerWidth(); return tblwidth; } };

/*
 * jQuery Plugin: "Popeye" - 
 * Copyright (C) 2008 - 2010 Christoph Schuessler (schreib@herr-schuessler.de)
 * http://dev.herr-schuessler.de/jquery/popeye/
 */
(function($){$.fn.popeye=function(options){var opts=$.extend({},$.fn.popeye.defaults,options);function debug(text,type){if(window.console&&window.console.log&&opts.debug){if(type=='info'&&window.console.info){window.console.info(text);}else if(type=='warn'&&window.console.warn){window.console.warn(text);}else{window.console.log(text);}}}return this.each(function(){$(this).addClass('ppy-active');var $self=$(this),img=$self.find('.ppy-imglist > li > a > img'),a=$self.find('.ppy-imglist > li > a'),tot=img.length,singleImageMode=(tot==1)?true:false,enlarged=false,cur=0,eclass='ppy-expanded',lclass='ppy-loading',sclass='ppy-single-image',ppyPlaceholder=$('<div class="ppy-placeholder"></div>'),ppyStageWrap=$('<div class="ppy-stagewrap"></div>'),ppyCaptionWrap=$('<div class="ppy-captionwrap"></div>'),ppyOuter=$self.find('.ppy-outer'),ppyStage=$self.find('.ppy-stage'),ppyNav=$self.find('.ppy-nav'),ppyPrev=$self.find('.ppy-prev'),ppyNext=$self.find('.ppy-next'),ppySwitchEnlarge=$self.find('.ppy-switch-enlarge'),ppySwitchCompact=$self.find('.ppy-switch-compact').addClass('ppy-hidden'),ppyCaption=$self.find('.ppy-caption'),ppyText=$self.find('.ppy-text'),ppyCounter=$self.find('.ppy-counter'),ppyCurrent=$self.find('.ppy-current'),ppyTotal=$self.find('.ppy-total'),cssSelf={position:'absolute',width:'auto',height:'auto',margin:0,top:0,left:(opts.direction=='right')?0:'auto',right:(opts.direction=='left')?0:'auto'},cssStage={height:ppyStage.height(),width:ppyStage.width()},cssCaption={height:ppyCaption.height()},cssPlaceholder={height:(opts.caption=='hover'||false)?ppyOuter.outerHeight():$self.outerHeight(),width:(opts.caption=='hover'||false)?ppyOuter.outerWidth():$self.outerWidth(),float:$self.css('float'),marginTop:$self.css('margin-top'),marginRight:$self.css('margin-right'),marginBottom:$self.css('margin-bottom'),marginLeft:$self.css('margin-left')};var cap=[];for(var i=0;i<img.length;i++){var extcap=$self.find('.ppy-imglist li').eq(i).find('.ppy-extcaption');cap[i]=extcap.length>0?extcap.html():img[i].alt;}if(!ppyStage.length||!ppyNav.length||!ppyOuter.length){debug('$.fn.popeye: Incorrect HTML structure','warn');}else if(tot===0){debug('$.fn.popeye: No images found','warn');}else{singleImageMode?debug('$.fn.popeye -> SingleImageMode started'):debug('$.fn.popeye -> '+tot+' thumbnails found.');init();}function showThumb(i,transition){transition=transition||false;i=i||cur;var cssStageImage={backgroundImage:'url('+img[i].src+')'};var cssTemp={height:'+=0'};if(enlarged){hideCaption();ppyStage.fadeTo((opts.duration/2),0).animate(cssStage,{queue:false,duration:opts.duration,easing:opts.easing,complete:function(){enlarged=false;debug('$.fn.showThumb: Entering COMPACT MODE','info');$self.removeClass(eclass);$self.css('z-index','');ppySwitchEnlarge.removeClass('ppy-hidden');ppySwitchCompact.addClass('ppy-hidden');showThumb();$(this).fadeTo((opts.duration/2),1);}});}else{if(transition){ppyStageWrap.addClass(lclass);ppyStage.fadeTo((opts.duration/2),0);var thumbPreloader=new Image();thumbPreloader.onload=function(){debug('$.fn.popeye.showThumb: Thumbnail '+i+' loaded','info');ppyStageWrap.removeClass(lclass);ppyStage.animate(cssTemp,1,'linear',function(){ppyStage.css(cssStageImage);$(this).fadeTo((opts.duration/2),1);if(opts.caption=='hover'){showCaption(cap[i]);}else if(opts.caption=='permanent'){updateCaption(cap[i]);}updateCounter();});thumbPreloader.onload=function(){};};thumbPreloader.src=img[i].src;}else{ppyStage.css(cssStageImage);updateCounter();showCaption(cap[i],true);}var preloader=new Image();preloader.onload=function(){debug('$.fn.popeye.showThumb: Image '+i+' loaded','info');preloader.onload=function(){};};preloader.src=a[i].href;}}function showImage(i){i=i||cur;ppyStageWrap.addClass(lclass);ppyStage.fadeTo((opts.duration/2),0);var allPpy=$('.'+eclass);allPpy.css('z-index',opts.zindex-1);$self.css('z-index',opts.zindex);var preloader=new Image();preloader.onload=function(){ppyStageWrap.removeClass(lclass);var cssStageTo={width:preloader.width,height:preloader.height};var cssStageIm={backgroundImage:'url('+a[i].href+')',backgroundPosition:'left top'};hideCaption();ppyStage.animate(cssStageTo,{queue:false,duration:opts.duration,easing:opts.easing,complete:function(){if(opts.navigation=='hover'){showNav();}enlarged=true;debug('$.fn.popeye.showImage: Entering ENLARGED MODE','info');$self.addClass(eclass);ppySwitchCompact.removeClass('ppy-hidden');ppySwitchEnlarge.addClass('ppy-hidden');updateCounter();$(this).css(cssStageIm).fadeTo((opts.duration/2),1);showCaption(cap[i]);preloadNeighbours();}});};preloader.src=a[i].href;}function updateCounter(i){i=i||cur;ppyTotal.text(tot);ppyCurrent.text(i+1);debug('$.fn.popeye.updateCounter: Displaying image '+(i+1)+' of '+tot);}function preloadNeighbours(i){i=i||cur;var preloaderNext=new Image();var preloaderPrev=new Image();var neighbour=i;if(neighbour<(tot-1)){neighbour++;}else{neighbour=0;}preloaderNext.src=a[i].href[neighbour];neighbour=i;if(neighbour<=0){neighbour=tot-1;}else{neighbour--;}preloaderPrev.src=a[i].href[neighbour];}function showNav(){ppyNav.stop().fadeTo(150,opts.opacity);}function hideNav(){ppyNav.stop().fadeTo(150,0);}function updateCaption(caption){if(opts.caption){ppyText.html(caption);ppyCaption.width(ppyStage.innerWidth());}}function showCaption(caption,force){if(caption&&opts.caption){updateCaption(caption);debug('$.fn.popeye.showCaption -> ppyCaptionWrap.outerHeight(true): '+ppyCaptionWrap.outerHeight(true));var cssTempCaption={visibility:'visible'};ppyCaption.css(cssTempCaption);if(opts.caption==='permanent'&&!enlarged){ppyCaption.css(cssCaption);}else{ppyCaption.animate({'height':ppyCaptionWrap.outerHeight(true)},{queue:false,duration:90,easing:opts.easing});}}else if(!caption&&!force){hideCaption();}}function hideCaption(){var cssTempCaption={visibility:'hidden',overflow:'hidden'};ppyCaption.width('0px');ppyCaption.animate({'height':'0px'},{queue:false,duration:90,easing:opts.easing,complete:function(){ppyCaption.css(cssTempCaption);}});}function previous(){if(cur<=0){cur=tot-1;}else{cur--;}if(enlarged){showImage(cur);}else{showThumb(cur,true);}return cur;}function next(){if(cur<(tot-1)){cur++;}else{cur=0;}if(enlarged){showImage(cur);}else{showThumb(cur,true);}return cur;}function init(){ppyPlaceholder.css(cssPlaceholder);$self.css(cssSelf);$self.wrap(ppyPlaceholder);ppyStageWrap=ppyStage.wrap(ppyStageWrap).parent();ppyCaptionWrap=ppyCaption.wrapInner(ppyCaptionWrap).children().eq(0);showThumb();if(opts.navigation=='hover'){hideNav();$self.hover(function(){showNav();},function(){hideNav();});ppyNav.hover(function(){showNav();},function(){hideNav();});}if(!singleImageMode){ppyPrev.click(previous);ppyNext.click(next);}else{$self.addClass(sclass);ppyPrev.remove();ppyNext.remove();ppyCounter.remove();}if(opts.caption=='hover'){hideCaption();$self.hover(function(){showCaption(cap[cur]);},function(){hideCaption(true);});}ppySwitchEnlarge.click(function(){showImage();return false;});ppySwitchCompact.click(function(){showThumb(cur);return false;});}});};$.fn.popeye.defaults={navigation:'hover',caption:'hover',zindex:10000,direction:'right',duration:240,opacity:0.8,easing:'swing',debug:false};})(jQuery);

/*
 * HoverIntent config and helper functions
 */

var config = {    
	sensitivity: 3, // number = sensitivity threshold (must be 1 or higher)    
	interval: 200,  // number = milliseconds for onMouseOver polling interval    
	over: doOpen,   // function = onMouseOver callback (REQUIRED)    
	timeout: 200,   // number = milliseconds delay before onMouseOut    
	out: doClose    // function = onMouseOut callback (REQUIRED)    
};
    
function doOpen() {
	$(this).addClass("hover");
}
 
function doClose() {
	$(this).removeClass("hover");
}

/*
 * Jquery document ready
 */

jQuery(document).ready(function($) {
		
	/* Add first/last classes */
	if ($.browser.msie && $.browser.version<="8.0") {
		$(".block p:last-child, .item-list li:last-child, .item-list p:last-child, td p:last-child, .box-content p:last-child").addClass("last");
		$(".meta-info span:first-child").addClass("first");
	}

	/* Add "ismac" class to apply MAC specific CSS patches */
	if (navigator.appVersion.indexOf("Mac")!=-1) {
		$("body").addClass("ismac");
	}
				
	/* Searchbox */
	$("#q, #sa").focus(function() {
			$("#searchbox").addClass("focus");
		}).blur(function() {
			$("#searchbox").removeClass("focus");
	});
	
	/* Init field hints */
	$(".fieldhint").fieldhint();
	
	/* Init main menu */
	$("#pm li.pm-level-1").hoverIntent(config);
	
	/* Init homepage resources menu */
	//$("#hr li.hr-level-1").hoverIntent(config);
	
	/* Set submenus of primary navigation to equal heights */
	$(".pm-sub").each(function() {
		$("ul", this).syncHeight();
	});
	
	/* Init dimmed table rows hover */
	$("tr.dimmed").hoverIntent(config);

	/* Set filter lists to equal heights */
	$(".tp-scroll .filter-list").each(function() {
		$("ul", this).syncHeight();
	});
	
	/* Init Accordion Menu */
	$(".acc-menu").initMenu();
	
	/* Init "bgiframe" to fix the annoying IE 6 select list : z-index bug  */
	$(".pm-sub-wrapper").bgiframe();
	
	/* Init Tabs */
	//$("ul.tabs").tabs("div.tabs-panes > div", {effect: 'fade', fadeOutSpeed: 400, initialIndex : 	1 });
	$("ul.tabs").tabs("div.tabs-panels > div");
	
	/* Dynamically generate table of contents index and page top links */
  if ($("#toc").length != 0 && $("#content h2, #content table h3").length >= 1) {	
  	$("#toc").append('<span>On this page:</span> <div><ul class="clearfix"></ul></div>')
		$("#content h2").each(function(i) {
    	var current = $(this);
    	current.attr("id", "section" + i);
    	$("#toc ul").append("<li><a href='#section" + i + "'>" + current.html() + "</a></li>");
    	if (i > 0) $("<p class='page-top'><a href='#page'>Top</a></p>").insertBefore(current);
		});
		$("#content table h3").each(function(i) {
   		var current = $(this);
    	current.attr("id", "section" + i);
    	$("#toc ul").append("<li><a href='#section" + i + "'>" + current.html() + "</a></li>");
    	if (i > 0) $("<div class='float-right'><a href='#page' class='page-top-link'>Top</a></div>").insertBefore(current);
		});
		$("#toc").hoverIntent(config);
		$("#toc").css({'background':'none'}); // get rid of loader image
	}

	/* Exclude specific link-types from tabbing */
	$(".pm-sub a, .hero-carousel a, .themes-carousel a, .featured-carousel a, .stories-carousel .item-list a, #toc a").attr( "tabindex", "-1"); 
	
	/* Init sidebar gallery (popeye) */
	var ppy = {
   	caption:    'permanent',
   	navigation: 'permanent',
    direction:  'left',
    zindex: '400'
   }
   $("#sidebar-gallery").popeye(ppy);
	
	/* Init facetted navigation "show more" links */
	$(".showmore-link").collapser({
		target: 'prev',
		targetOnly: null,
		effect : 'slide',
		changeText: true,
		expandHtml: '+ Show More',
		collapseHtml: '- Show Fewer',
		expandClass: '',
		collapseClass: ''
	});

	/* Facetted navigation time: show custom date range form on click */
	$("#fl-daterange").click(function() {
		$(this).css({"font-weight":"700", "color":"#333"}).next().show();
		$("#fl-datefrom").focus();
		return false;
	});
	
	/* Init "show more information" links */
	$(".toggle-link").collapser({
		target: 'siblings',
		targetOnly: '.toggle',
		effect : 'slide',
		changeText: true,
		expandHtml: '+ Show More information',
		collapseHtml: '- Show Fewer information',
		expandClass: '',
		collapseClass: ''
	});
	
	/* Init homepage carousels */
	if ($("body").hasClass("page-homepage")) {
  	
		$("#c-hero").carouFredSel({
			items       : 1,
			auto : {
				play 	: true, 
				pauseDuration	: 7000
			},
			prev : {   
				button  : "#c-hero-prev",
				key     : "left"
			},
			next : {
				button  : "#c-hero-next",
				key     : "right"
			}, 
			scroll : {
				easing			: "easeInOutQuart",
				duration		: 750,							
				pauseOnHover	: true
			}
		});
		
		var cfs = $("#c-themes").carouFredSel({
			items       : 1,
			auto : {
				play 	: false
			},
			prev : {   
				button  : "#c-themes-prev",
				key     : "left"
			},
			next : {
				button  : "#c-themes-next",
				key     : "right"			
			}, 
			scroll : {
				easing			: "easeInOutQuart",
				duration		: 750,
				onAfter : function() {
  			 var numex = cfs.current_position();
  			 if (numex < 2) {
  			 	$("#themes h1 span:first").addClass("current");
  			 	$("#themes h1 span:last").removeClass("current");
  			 }
  			 else {
  			 	$("#themes h1 span:last").addClass("current");
  			 	$("#themes h1 span:first").removeClass("current");
  			 }
				}
			}
		});
		
		/* Init homepage sectors & themes qtips */
		$("#c-themes a[title]").qtip({
			style: { 
      	tip: true,
      	width: 240,
      	name: 'dark'
   		},
			position: {
      	corner: {
         target: 'topMiddle',
         tooltip: 'bottomMiddle'
      	}, 
      	adjust: { screen: true }
   		}
		});
		
	}
	
	/* Init featured contents carousel */
	$("#c-featured").carouFredSel({
		items       : 1,
		auto : {
			play 	: true, 
			pauseDuration	: 7000
		}, 
		scroll	: {
			easing			: "easeInOutQuart",
			duration		: 750,							
			pauseOnHover	: true
		},
	   pagination : {
			container       : "#c-featured-pag",
			anchorBuilder   : function(nr) {
				var src = $("#c-featured li:nth-child(" + nr + ")").find('img').attr('src');
				return "<a><img src='" + src + "' /></a>";
	     }
	   }
	});
		
	/* Init content carousel */
	$("#c-content").carouFredSel({
		items       : 3,
		height : 'auto', 
		auto : {
			play 	: false, 
			pauseDuration	: 7000
		}, 
		scroll	: {
			items : 3, 
			easing			: "easeInOutQuart",
			duration		: 750,							
			pauseOnHover	: true
		},
	   pagination : {
			container       : "#c-content-pag",
			anchorBuilder   : function(nr) {
				return "<a><span>" + nr + "</span></a>";
	     }	    
		}
	});
	
	/* Init graphs tooltips */
	$(".graphs-220 .g-item[title]").qtip({
			style: { 
      	tip: true,
      	width: 240,
      	name: 'dark'
   		},
			position: {
      	corner: {
         target: 'topMiddle',
         tooltip: 'bottomMiddle'
      	}
   		}
	});
	
	/* Init media browser list items tooltips */
	$("#mb-content li[title]").qtip({
			style: { 
      	tip: true,
      	width: 240,
      	name: 'dark'
   		},
			position: {
      	corner: {
         target: 'topMiddle',
         tooltip: 'bottomMiddle'
      	}, 
      	adjust: { screen: true }
   		}
	});
	
	/* Init generic tooltips */
	$("a.qtip[title]").qtip({
			style: { 
      	tip: true,
      	width: 240,
      	name: 'dark'
   		},
			position: {
      	corner: {
         target: 'topMiddle',
         tooltip: 'bottomMiddle'
      	}, 
      	adjust: { screen: true }
   		}
	});
	
	/* Init form tooltips */
	$("input[tip], select[tip], textarea[tip]").each(function() {

    var content = $(this).attr("tip");

    $(this).qtip({
        content: content,
        position: {
            corner: {
                target: 'topRight',
                tooltip: 'bottomLeft'
            }
        },
        style: { 
      		tip: true,
      		width: 340,
      		name: 'dark'
   			}, 
     		position: { corner: { target: 'rightMiddle', tooltip: 'leftMiddle'}, adjust: { screen: false, x: 4 } }, 
     		show: { when: 'focus', delay: 2000, effect : { type: 'fade', length: 1000 } }, 
     		hide: { when: 'blur' }
    });
    
	});

	
  /* Init fixed table headers */
  $(".table-header-fixed").fixedtableheader();
  
	/* Podcast page: select all text in copy-paste-rss text field */
	$("#copy-paste-rss").focus(function(){
    this.select();
	});
	
	/* Hide all images on print by adding the noprint class */
	$("#main a").has("img").addClass("noprint");

/* Kludge for IE6, ADB Sectors/Themes pictures weren't clickable */
  $('#c-themes span').click(function() { if ($.browser.msie) { location.href = $(this).parent('a').attr('href'); } });
});