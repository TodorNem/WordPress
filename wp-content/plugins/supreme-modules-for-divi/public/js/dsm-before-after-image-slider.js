(function(fn){if(typeof define==='function'&&define.amd){define([],fn)}else if((typeof module!=="undefined"&&module!==null)&&module.exports){module.exports=fn}else{fn()}})(function(){var assign=Object.assign||window.jQuery&&jQuery.extend;var threshold=8;var requestFrame=(function(){return(window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||window.oRequestAnimationFrame||window.msRequestAnimationFrame||function(fn,element){return window.setTimeout(function(){fn()},25)})})();(function(){if(typeof window.CustomEvent==="function")return!1;function CustomEvent(event,params){params=params||{bubbles:!1,cancelable:!1,detail:undefined};var evt=document.createEvent('CustomEvent');evt.initCustomEvent(event,params.bubbles,params.cancelable,params.detail);return evt}
CustomEvent.prototype=window.Event.prototype;window.CustomEvent=CustomEvent})();var ignoreTags={textarea:!0,input:!0,select:!0,button:!0};var mouseevents={move:'mousemove',cancel:'mouseup dragstart',end:'mouseup'};var touchevents={move:'touchmove',cancel:'touchend',end:'touchend'};var rspaces=/\s+/;var eventOptions={bubbles:!0,cancelable:!0};var eventsSymbol=typeof Symbol==="function"?Symbol('events'):{};function createEvent(type){return new CustomEvent(type,eventOptions)}
function getEvents(node){return node[eventsSymbol]||(node[eventsSymbol]={})}
function on(node,types,fn,data,selector){types=types.split(rspaces);var events=getEvents(node);var i=types.length;var handlers,type;function handler(e){fn(e,data)}
while(i--){type=types[i];handlers=events[type]||(events[type]=[]);handlers.push([fn,handler]);node.addEventListener(type,handler)}}
function off(node,types,fn,selector){types=types.split(rspaces);var events=getEvents(node);var i=types.length;var type,handlers,k;if(!events){return}
while(i--){type=types[i];handlers=events[type];if(!handlers){continue}
k=handlers.length;while(k--){if(handlers[k][0]===fn){node.removeEventListener(type,handlers[k][1]);handlers.splice(k,1)}}}}
function trigger(node,type,properties){var event=createEvent(type);if(properties){assign(event,properties)}
node.dispatchEvent(event)}
function Timer(fn){var callback=fn,active=!1,running=!1;function trigger(time){if(active){callback();requestFrame(trigger);running=!0;active=!1}
else{running=!1}}
this.kick=function(fn){active=!0;if(!running){trigger()}};this.end=function(fn){var cb=callback;if(!fn){return}
if(!running){fn()}
else{callback=active?function(){cb();fn()}:fn;active=!0}}}
function noop(){}
function preventDefault(e){e.preventDefault()}
function isIgnoreTag(e){return!!ignoreTags[e.target.tagName.toLowerCase()]}
function isPrimaryButton(e){return(e.which===1&&!e.ctrlKey&&!e.altKey)}
function identifiedTouch(touchList,id){var i,l;if(touchList.identifiedTouch){return touchList.identifiedTouch(id)}
i=-1;l=touchList.length;while(++i<l){if(touchList[i].identifier===id){return touchList[i]}}}
function changedTouch(e,data){var touch=identifiedTouch(e.changedTouches,data.identifier);if(!touch){return}
if(touch.pageX===data.pageX&&touch.pageY===data.pageY){return}
return touch}
function mousedown(e){if(!isPrimaryButton(e)){return}
if(isIgnoreTag(e)){return}
on(document,mouseevents.move,mousemove,e);on(document,mouseevents.cancel,mouseend,e)}
function mousemove(e,data){checkThreshold(e,data,e,removeMouse)}
function mouseend(e,data){removeMouse()}
function removeMouse(){off(document,mouseevents.move,mousemove);off(document,mouseevents.cancel,mouseend)}
function touchstart(e){if(ignoreTags[e.target.tagName.toLowerCase()]){return}
var touch=e.changedTouches[0];var data={target:touch.target,pageX:touch.pageX,pageY:touch.pageY,identifier:touch.identifier,touchmove:function(e,data){touchmove(e,data)},touchend:function(e,data){touchend(e,data)}};on(document,touchevents.move,data.touchmove,data);on(document,touchevents.cancel,data.touchend,data)}
function touchmove(e,data){var touch=changedTouch(e,data);if(!touch){return}
checkThreshold(e,data,touch,removeTouch)}
function touchend(e,data){var touch=identifiedTouch(e.changedTouches,data.identifier);if(!touch){return}
removeTouch(data)}
function removeTouch(data){off(document,touchevents.move,data.touchmove);off(document,touchevents.cancel,data.touchend)}
function checkThreshold(e,data,touch,fn){var distX=touch.pageX-data.pageX;var distY=touch.pageY-data.pageY;if((distX*distX)+(distY*distY)<(threshold*threshold)){return}
triggerStart(e,data,touch,distX,distY,fn)}
function triggerStart(e,data,touch,distX,distY,fn){var touches=e.targetTouches;var time=e.timeStamp-data.timeStamp;var template={altKey:e.altKey,ctrlKey:e.ctrlKey,shiftKey:e.shiftKey,startX:data.pageX,startY:data.pageY,distX:distX,distY:distY,deltaX:distX,deltaY:distY,pageX:touch.pageX,pageY:touch.pageY,velocityX:distX/time,velocityY:distY/time,identifier:data.identifier,targetTouches:touches,finger:touches?touches.length:1,enableMove:function(){this.moveEnabled=!0;this.enableMove=noop;e.preventDefault()}};trigger(data.target,'movestart',template);fn(data)}
function activeMousemove(e,data){var timer=data.timer;data.touch=e;data.timeStamp=e.timeStamp;timer.kick()}
function activeMouseend(e,data){var target=data.target;var event=data.event;var timer=data.timer;removeActiveMouse();endEvent(target,event,timer,function(){setTimeout(function(){off(target,'click',preventDefault)},0)})}
function removeActiveMouse(){off(document,mouseevents.move,activeMousemove);off(document,mouseevents.end,activeMouseend)}
function activeTouchmove(e,data){var event=data.event;var timer=data.timer;var touch=changedTouch(e,event);if(!touch){return}
e.preventDefault();event.targetTouches=e.targetTouches;data.touch=touch;data.timeStamp=e.timeStamp;timer.kick()}
function activeTouchend(e,data){var target=data.target;var event=data.event;var timer=data.timer;var touch=identifiedTouch(e.changedTouches,event.identifier);if(!touch){return}
removeActiveTouch(data);endEvent(target,event,timer)}
function removeActiveTouch(data){off(document,touchevents.move,data.activeTouchmove);off(document,touchevents.end,data.activeTouchend)}
function updateEvent(event,touch,timeStamp){var time=timeStamp-event.timeStamp;event.distX=touch.pageX-event.startX;event.distY=touch.pageY-event.startY;event.deltaX=touch.pageX-event.pageX;event.deltaY=touch.pageY-event.pageY;event.velocityX=0.3*event.velocityX+0.7*event.deltaX/time;event.velocityY=0.3*event.velocityY+0.7*event.deltaY/time;event.pageX=touch.pageX;event.pageY=touch.pageY}
function endEvent(target,event,timer,fn){timer.end(function(){trigger(target,'moveend',event);return fn&&fn()})}
function movestart(e){if(e.defaultPrevented){return}
if(!e.moveEnabled){return}
var event={startX:e.startX,startY:e.startY,pageX:e.pageX,pageY:e.pageY,distX:e.distX,distY:e.distY,deltaX:e.deltaX,deltaY:e.deltaY,velocityX:e.velocityX,velocityY:e.velocityY,identifier:e.identifier,targetTouches:e.targetTouches,finger:e.finger};var data={target:e.target,event:event,timer:new Timer(update),touch:undefined,timeStamp:e.timeStamp};function update(time){updateEvent(event,data.touch,data.timeStamp);trigger(data.target,'move',event)}
if(e.identifier===undefined){on(e.target,'click',preventDefault);on(document,mouseevents.move,activeMousemove,data);on(document,mouseevents.end,activeMouseend,data)}
else{data.activeTouchmove=function(e,data){activeTouchmove(e,data)};data.activeTouchend=function(e,data){activeTouchend(e,data)};on(document,touchevents.move,data.activeTouchmove,data);on(document,touchevents.end,data.activeTouchend,data)}}
on(document,'mousedown',mousedown);on(document,'touchstart',touchstart);on(document,'movestart',movestart);if(!window.jQuery){return}
var properties=("startX startY pageX pageY distX distY deltaX deltaY velocityX velocityY").split(' ');function enableMove1(e){e.enableMove()}
function enableMove2(e){e.enableMove()}
function enableMove3(e){e.enableMove()}
function add(handleObj){var handler=handleObj.handler;handleObj.handler=function(e){var i=properties.length;var property;while(i--){property=properties[i];e[property]=e.originalEvent[property]}
handler.apply(this,arguments)}}
jQuery.event.special.movestart={setup:function(){on(this,'movestart',enableMove1);return!1},teardown:function(){off(this,'movestart',enableMove1);return!1},add:add};jQuery.event.special.move={setup:function(){on(this,'movestart',enableMove2);return!1},teardown:function(){off(this,'movestart',enableMove2);return!1},add:add};jQuery.event.special.moveend={setup:function(){on(this,'movestart',enableMove3);return!1},teardown:function(){off(this,'movestart',enableMove3);return!1},add:add}});(function($){$.fn.twentytwenty=function(options){var options=$.extend({default_offset_pct:0.5,orientation:'horizontal',before_label:'Before',after_label:'After',no_overlay:!1,move_slider_on_hover:!1,move_with_handle_only:!0,click_to_move:!1},options);return this.each(function(){var sliderPct=options.default_offset_pct;var container=$(this);var sliderOrientation=options.orientation;var beforeDirection=(sliderOrientation==='vertical')?'down':'left';var afterDirection=(sliderOrientation==='vertical')?'up':'right';container.wrap("<div class='dsm-before-after-image-slider-wrapper dsm-before-after-image-slider-"+sliderOrientation+"'></div>");if(!options.no_overlay){container.append("<div class='dsm-before-after-image-slider-overlay'></div>");var overlay=container.find(".dsm-before-after-image-slider-overlay");overlay.append("<div class='dsm-before-after-image-slider-before-label' data-content='"+options.before_label+"'></div>");overlay.append("<div class='dsm-before-after-image-slider-after-label' data-content='"+options.after_label+"'></div>")}
var beforeImg=container.find("img:first");var afterImg=container.find("img:last");container.append("<div class='dsm-before-after-image-slider-handle'></div>");var slider=container.find(".dsm-before-after-image-slider-handle");slider.append("<span class='dsm-before-after-image-slider-"+beforeDirection+"-arrow'></span>");slider.append("<span class='dsm-before-after-image-slider-"+afterDirection+"-arrow'></span>");container.addClass("dsm-before-after-image-slider-container");beforeImg.addClass("dsm-before-after-image-slider-before");afterImg.addClass("dsm-before-after-image-slider-after");var calcOffset=function(dimensionPct){var w=beforeImg.width();var h=beforeImg.height();return{w:w+"px",h:h+"px",cw:(dimensionPct*w)+"px",ch:(dimensionPct*h)+"px"}};var adjustContainer=function(offset){if(sliderOrientation==='vertical'){beforeImg.css("clip","rect(0,"+offset.w+","+offset.ch+",0)");afterImg.css("clip","rect("+offset.ch+","+offset.w+","+offset.h+",0)")}
else{beforeImg.css("clip","rect(0,"+offset.cw+","+offset.h+",0)");afterImg.css("clip","rect(0,"+offset.w+","+offset.h+","+offset.cw+")")}
container.css("height",offset.h)};var adjustSlider=function(pct){var offset=calcOffset(pct);slider.css((sliderOrientation==="vertical")?"top":"left",(sliderOrientation==="vertical")?offset.ch:offset.cw);adjustContainer(offset)};var minMaxNumber=function(num,min,max){return Math.max(min,Math.min(max,num))};var getSliderPercentage=function(positionX,positionY){var sliderPercentage=(sliderOrientation==='vertical')?(positionY-offsetY)/imgHeight:(positionX-offsetX)/imgWidth;return minMaxNumber(sliderPercentage,0,1)};$(window).on("resize.twentytwenty",function(e){adjustSlider(sliderPct)});var offsetX=0;var offsetY=0;var imgWidth=0;var imgHeight=0;var onMoveStart=function(e){if(((e.distX>e.distY&&e.distX<-e.distY)||(e.distX<e.distY&&e.distX>-e.distY))&&sliderOrientation!=='vertical'){e.preventDefault()}
else if(((e.distX<e.distY&&e.distX<-e.distY)||(e.distX>e.distY&&e.distX>-e.distY))&&sliderOrientation==='vertical'){e.preventDefault()}
container.addClass("active");offsetX=container.offset().left;offsetY=container.offset().top;imgWidth=beforeImg.width();imgHeight=beforeImg.height()};var onMove=function(e){if(container.hasClass("active")){sliderPct=getSliderPercentage(e.pageX,e.pageY);adjustSlider(sliderPct)}};var onMoveEnd=function(){container.removeClass("active")};var moveTarget=options.move_with_handle_only?slider:container;moveTarget.on("movestart",onMoveStart);moveTarget.on("move",onMove);moveTarget.on("moveend",onMoveEnd);if(options.move_slider_on_hover){container.on("mouseenter",onMoveStart);container.on("mousemove",onMove);container.on("mouseleave",onMoveEnd)}
slider.on("touchmove",function(e){e.preventDefault()});container.find("img").on("mousedown",function(event){event.preventDefault()});if(options.click_to_move){container.on('click',function(e){offsetX=container.offset().left;offsetY=container.offset().top;imgWidth=beforeImg.width();imgHeight=beforeImg.height();sliderPct=getSliderPercentage(e.pageX,e.pageY);adjustSlider(sliderPct)})}
$(window).trigger("resize.twentytwenty")})}})(jQuery)