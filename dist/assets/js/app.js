!function(e){var t={};function i(n){if(t[n])return t[n].exports;var o=t[n]={i:n,l:!1,exports:{}};return e[n].call(o.exports,o,o.exports,i),o.l=!0,o.exports}i.m=e,i.c=t,i.d=function(e,t,n){i.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},i.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},i.t=function(e,t){if(1&t&&(e=i(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(i.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)i.d(n,o,function(t){return e[t]}.bind(null,o));return n},i.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return i.d(t,"a",t),t},i.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},i.p="./dist/assets",i(i.s=3)}([function(e,t,i){var n=i(1),o=i(2);"string"==typeof(o=o.__esModule?o.default:o)&&(o=[[e.i,o,""]]);var r={insert:"head",singleton:!1},s=(n(o,r),o.locals?o.locals:{});e.exports=s},function(e,t,i){"use strict";var n,o=function(){return void 0===n&&(n=Boolean(window&&document&&document.all&&!window.atob)),n},r=function(){var e={};return function(t){if(void 0===e[t]){var i=document.querySelector(t);if(window.HTMLIFrameElement&&i instanceof window.HTMLIFrameElement)try{i=i.contentDocument.head}catch(e){i=null}e[t]=i}return e[t]}}(),s=[];function a(e){for(var t=-1,i=0;i<s.length;i++)if(s[i].identifier===e){t=i;break}return t}function l(e,t){for(var i={},n=[],o=0;o<e.length;o++){var r=e[o],l=t.base?r[0]+t.base:r[0],c=i[l]||0,d="".concat(l," ").concat(c);i[l]=c+1;var u=a(d),f={css:r[1],media:r[2],sourceMap:r[3]};-1!==u?(s[u].references++,s[u].updater(f)):s.push({identifier:d,updater:h(f,t),references:1}),n.push(d)}return n}function c(e){var t=document.createElement("style"),n=e.attributes||{};if(void 0===n.nonce){var o=i.nc;o&&(n.nonce=o)}if(Object.keys(n).forEach((function(e){t.setAttribute(e,n[e])})),"function"==typeof e.insert)e.insert(t);else{var s=r(e.insert||"head");if(!s)throw new Error("Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid.");s.appendChild(t)}return t}var d,u=(d=[],function(e,t){return d[e]=t,d.filter(Boolean).join("\n")});function f(e,t,i,n){var o=i?"":n.media?"@media ".concat(n.media," {").concat(n.css,"}"):n.css;if(e.styleSheet)e.styleSheet.cssText=u(t,o);else{var r=document.createTextNode(o),s=e.childNodes;s[t]&&e.removeChild(s[t]),s.length?e.insertBefore(r,s[t]):e.appendChild(r)}}function m(e,t,i){var n=i.css,o=i.media,r=i.sourceMap;if(o?e.setAttribute("media",o):e.removeAttribute("media"),r&&btoa&&(n+="\n/*# sourceMappingURL=data:application/json;base64,".concat(btoa(unescape(encodeURIComponent(JSON.stringify(r))))," */")),e.styleSheet)e.styleSheet.cssText=n;else{for(;e.firstChild;)e.removeChild(e.firstChild);e.appendChild(document.createTextNode(n))}}var p=null,v=0;function h(e,t){var i,n,o;if(t.singleton){var r=v++;i=p||(p=c(t)),n=f.bind(null,i,r,!1),o=f.bind(null,i,r,!0)}else i=c(t),n=m.bind(null,i,t),o=function(){!function(e){if(null===e.parentNode)return!1;e.parentNode.removeChild(e)}(i)};return n(e),function(t){if(t){if(t.css===e.css&&t.media===e.media&&t.sourceMap===e.sourceMap)return;n(e=t)}else o()}}e.exports=function(e,t){(t=t||{}).singleton||"boolean"==typeof t.singleton||(t.singleton=o());var i=l(e=e||[],t);return function(e){if(e=e||[],"[object Array]"===Object.prototype.toString.call(e)){for(var n=0;n<i.length;n++){var o=a(i[n]);s[o].references--}for(var r=l(e,t),c=0;c<i.length;c++){var d=a(i[c]);0===s[d].references&&(s[d].updater(),s.splice(d,1))}i=r}}}},function(e,t,i){},function(e,t,i){"use strict";i.r(t);i(0);function n(e,t){for(var i=0;i<t.length;i++){var n=t[i];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}var o=function(){function e(t){var i=this;!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.form=t,this.form_fields=new Object,this.form_inputs=this.form.querySelectorAll('input:not([type="checkbox"])'),this.form_inputs.forEach((function(e){i.form_fields[e.name]=!1})),this.regex={name:/^[a-zA-ZÀ-ÿ ]{2,60}$/,email:/^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+.[a-zA-Z]+$/,password:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{4,}$/}}var t,i,o;return t=e,(i=[{key:"noErrors",value:function(){for(var e in this.form_fields)if(!this.form_fields[e])return!1;return!0}},{key:"validateSubmit",value:function(){var e=this;this.form_inputs.forEach((function(t){var i=e.regex[t.name];"passwordConfirmation"===t.name?e.validatePasswordConfirmation():i.test(t.value.trim())&&(e.form_fields[t.name]=!0)})),this.noErrors()?(this.form.submit(),this.form.reset()):this.displayStatus()}},{key:"validatePasswordConfirmation",value:function(){var e=Array.from(this.form_inputs).find((function(e){return"passwordConfirmation"===e.name})),t=Array.from(this.form_inputs).find((function(e){return"password"===e.name}));""===e.value||e.value!==t.value?(e.closest(".form-group").classList.remove("correct"),e.closest(".form-group").classList.add("incorrect"),e.parentElement.nextElementSibling.classList.add("active"),e.nextElementSibling.classList.add("fa-times-circle"),e.nextElementSibling.classList.remove("fa-check-circle"),this.form_fields.passwordConfirmation=!1):(e.closest(".form-group").classList.remove("incorrect"),e.closest(".form-group").classList.add("correct"),e.parentElement.nextElementSibling.classList.remove("active"),e.nextElementSibling.classList.remove("fa-times-circle"),e.nextElementSibling.classList.add("fa-check-circle"),this.form_fields.passwordConfirmation=!0)}},{key:"displayStatus",value:function(){var e=this;this.form_inputs.forEach((function(t){e.form_fields[t.name]?(t.closest(".form-group").classList.remove("incorrect"),t.parentElement.nextElementSibling.classList.remove("active"),t.closest(".form-group").classList.add("correct"),t.nextElementSibling.classList.remove("fa-times-circle"),t.nextElementSibling.classList.add("fa-check-circle")):(t.closest(".form-group").classList.remove("correct"),t.closest(".form-group").classList.add("incorrect"),t.parentElement.nextElementSibling.classList.add("active"),t.nextElementSibling.classList.add("fa-times-circle"),t.nextElementSibling.classList.remove("fa-check-circle"))}))}}])&&n(t.prototype,i),o&&n(t,o),e}();function r(e,t){for(var i=0;i<t.length;i++){var n=t[i];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}function s(e,t){for(var i=0;i<t.length;i++){var n=t[i];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(e,n.key,n)}}new(function(){function e(t){var i=this;!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.http=t,this.body=document.getElementById("bodyJsPointer"),this.notification=document.querySelector(".notification"),this.forms=document.querySelectorAll("form"),this.profile_parent=document.getElementById("profile-content-parent"),document.querySelectorAll("[data-popup]").forEach((function(e){e.addEventListener("click",i.showPopup.bind(i))})),document.getElementById("close-popup").addEventListener("click",this.closePopup.bind(this)),null!==this.notification&&this.notification.addEventListener("click",this.closeNotification.bind(this)),null!==this.profile_parent&&this.profile_parent.addEventListener("click",this.profileContentChanger.bind(this)),this.loadFormEvents(),this.loadCarousels(),this.stickyNav()}var t,i,n;return t=e,(i=[{key:"hideFFScrollbars",value:function(){function e(e){/firefox/i.test(navigator.userAgent)&&window.innerWidth>575&&(e.target.parentNode.style.height=e.target.offsetHeight-17+"px")}document.addEventListener("glider-loaded",e),document.addEventListener("glider-refresh",e)}},{key:"showPopup",value:function(e){var t=this;e.preventDefault();var i=document.querySelector(".menu__popup"),n=document.querySelectorAll(".popup__content"),o=document.getElementById("overlay");n.forEach((function(n){e.target.dataset.popup===n.dataset.popupname?n.classList.contains("active")?(n.classList.remove("active"),i.classList.remove("active")):(o.classList.add("active"),t.body.classList.add("noscroll"),i.classList.add("active"),n.classList.toggle("active")):n.classList.remove("active")})),i.classList.contains("active")||(o.classList.remove("active"),this.body.classList.remove("noscroll"))}},{key:"closePopup",value:function(e){document.querySelectorAll(".popup__content").forEach((function(e){e.classList.remove("active")})),document.querySelector(".menu__popup").classList.remove("active"),overlay.classList.remove("active"),this.body.classList.remove("noscroll")}},{key:"profileContentChanger",value:function(e){if(e.target.classList.contains("profile-content__option")){var t=Array.from(document.querySelector(".profile-content__menu").getElementsByTagName("li")),i=Array.from(document.querySelector(".profile-content__body").getElementsByClassName("profile-template"));if(!e.target.classList.contains("active")){var n=i.find((function(t){return t.dataset.action===e.target.dataset.action}));t.forEach((function(t){t.dataset.action!==e.target.dataset.action&&t.classList.remove("active")})),i.forEach((function(t){t.dataset.action!==e.target.dataset.action&&t.classList.remove("active")})),n.classList.add("active"),e.target.classList.add("active")}}}},{key:"closeNotification",value:function(e){"close-notification"===e.target.id&&(document.querySelector(".notification").style.display="none")}},{key:"loadFormEvents",value:function(){this.body.addEventListener("submit",(function(e){e.preventDefault(),"login_form"===e.target.id?e.target.submit():new o(e.target).validateSubmit()}))}},{key:"stickyNav",value:function(){window.addEventListener("scroll",(function(){document.getElementById("menu").classList.toggle("sticky",window.scrollY>0)}))}},{key:"loadCarousels",value:function(){new Glider(document.querySelector(".items-with-discount"),{slidesToShow:2,slidesToScroll:2,scrollLock:!0,itemWidth:155,rewind:!0,draggable:!0,arrows:{prev:".glider-prev",next:".glider-next"},responsive:[{breakpoint:320,settings:{itemWidth:197,slidesToShow:2,slidesToScroll:2}},{breakpoint:400,settings:{itemWidth:197,slidesToShow:2,slidesToScroll:2}},{breakpoint:500,settings:{itemWidth:160,slidesToShow:3,slidesToScroll:3}},{breakpoint:550,settings:{itemWidth:170,slidesToShow:3,slidesToScroll:3}},{breakpoint:601,settings:{slidesToShow:1,slidesToScroll:1}}]}),new Glider(document.querySelector(".best-sellers-carousel"),{slidesToShow:2,slidesToScroll:2,itemWidth:172,scrollLock:!0,draggable:!0,rewind:!0,arrows:{prev:".best-prev",next:".best-next"},responsive:[{breakpoint:400,settings:{itemWidth:197,slidesToShow:2,slidesToScroll:2}},{breakpoint:500,settings:{itemWidth:160,slidesToShow:3,slidesToScroll:3}},{breakpoint:550,settings:{itemWidth:170,slidesToShow:3,slidesToScroll:3}},{breakpoint:600,settings:{itemWidth:170,slidesToShow:3,slidesToScroll:3}},{breakpoint:760,settings:{itemWidth:190,slidesToShow:4,slidesToScroll:4}}]}),new Glider(document.querySelector(".just-arrived-carousel"),{slidesToShow:2,slidesToScroll:2,itemWidth:172,scrollLock:!0,draggable:!0,rewind:!0,arrows:{prev:".ja-prev",next:".ja-next"},responsive:[{breakpoint:400,settings:{itemWidth:197,slidesToShow:2,slidesToScroll:2}},{breakpoint:499,settings:{itemWidth:160,slidesToShow:3,slidesToScroll:3}},{breakpoint:550,settings:{itemWidth:170,slidesToShow:3,slidesToScroll:3}},{breakpoint:600,settings:{itemWidth:170,slidesToShow:3,slidesToScroll:3}},{breakpoint:760,settings:{itemWidth:180,slidesToShow:4,slidesToScroll:4}}]}),this.hideFFScrollbars()}}])&&r(t.prototype,i),n&&r(t,n),e}())(new(function(){function e(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.request=new XMLHttpRequest,this.baseURL="http://localhost/shoppingcart/"}var t,i,n;return t=e,(i=[{key:"get",value:function(e){var t=this;return new Promise((function(i,n){t.request.addEventListener("readystatechange",(function(){if(4===t.request.readyState&&200===t.request.status){var e=JSON.parse(JSON.stringify(t.request.responseText));i(e)}else 4===t.readyState&&n("Error here dude")})),t.request.open("GET",t.baseURL+e),t.request.send()}))}},{key:"post",value:function(){}}])&&s(t.prototype,i),n&&s(t,n),e}()))}]);