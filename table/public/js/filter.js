(()=>{function e(t){return e="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},e(t)}function t(t,r){for(var n=0;n<r.length;n++){var i=r[n];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(t,(l=i.key,o=void 0,o=function(t,r){if("object"!==e(t)||null===t)return t;var n=t[Symbol.toPrimitive];if(void 0!==n){var i=n.call(t,r||"default");if("object"!==e(i))return i;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===r?String:Number)(t)}(l,"string"),"symbol"===e(o)?o:String(o)),i)}var l,o}var r=function(){function e(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e)}var r,n,i;return r=e,(n=[{key:"loadData",value:function(e){$.ajax({type:"GET",url:$(".filter-data-url").val(),data:{class:$(".filter-data-class").val(),key:e.val(),value:e.closest(".filter-item").find(".filter-column-value").val()},success:function(t){var r=$.map(t.data,(function(e,t){return{id:t,name:e}}));e.closest(".filter-item").find(".filter-column-value-wrap").html(t.html);var n=e.closest(".filter-item").find(".filter-column-value");n.length&&"text"===n.prop("type")&&(n.typeahead({source:r}),n.data("typeahead").source=r),RealDriss.initResources()},error:function(e){RealDriss.handleError(e)}})}},{key:"init",value:function(){var e=this;$.each($(".filter-items-wrap .filter-column-key"),(function(t,r){$(r).val()&&e.loadData($(r))})),$(document).on("change",".filter-column-key",(function(t){e.loadData($(t.currentTarget))})),$(document).on("click",".btn-reset-filter-item",(function(e){e.preventDefault();var t=$(e.currentTarget);t.closest(".filter-item").find(".filter-column-key").val("").trigger("change"),t.closest(".filter-item").find(".filter-column-operator").val("="),t.closest(".filter-item").find(".filter-column-value").val("")})),$(document).on("click",".add-more-filter",(function(){var t=$(document).find(".sample-filter-item-wrap").html();$(document).find(".filter-items-wrap").append(t.replace("<script>","").replace("<\\/script>","")),RealDriss.initResources();var r=$(document).find(".filter-items-wrap .filter-item:last-child").find(".filter-column-key");$(r).val()&&e.loadData(r)})),$(document).on("click",".btn-remove-filter-item",(function(e){e.preventDefault(),$(e.currentTarget).closest(".filter-item").remove()}))}}])&&t(r.prototype,n),i&&t(r,i),Object.defineProperty(r,"prototype",{writable:!1}),e}();$(document).ready((function(){(new r).init()}))})();