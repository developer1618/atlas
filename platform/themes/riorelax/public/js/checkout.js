$(document).ready((function(){$(".service-item").on("change",(function(){var e=[];$(".service-item:checked").each((function(t,o){e[t]=$(o).val()})),$("body").css("cursor","progress"),$(".custom-checkbox label").css("cursor","progress"),$.ajax({type:"GET",cache:!1,url:"/ajax/calculate-amount",data:{room_id:$("input[name=room_id]").val(),start_date:$("input[name=start_date]").val(),end_date:$("input[name=end_date]").val(),services:e},success:function(e){alertvar t=e.error,o=e.data;t||($(".total-amount-text").text(o.total_amount),$("input[name=amount]").val(o.amount_raw),$(".amount-text").text(o.sub_total),$(".discount-text").text(o.discount_amount),$(".tax-text").text(o.tax_amount)),$("body").css("cursor","default"),$(".custom-checkbox label").css("cursor","pointer")},error:function(){$("body").css("cursor","default"),$(".custom-checkbox label").css("cursor","pointer")}})})),$(".create-customer").on("change",'input[name="register_customer"]',(function(e){$formCreate=$(".form-create-customer-password"),e.target.checked?$formCreate.removeClass("d-none"):$formCreate.addClass("d-none")}));var e=function(){var e=[];$(".service-item:checked").each((function(t,o){e[t]=$(o).val()})),$.ajax({url:"/ajax/calculate-amount",type:"GET",data:{room_id:$("input[name=room_id]").val(),start_date:$("input[name=start_date]").val(),end_date:$("input[name=end_date]").val(),services:e},success:function(e){var t,o=e.error,a=e.message,r=e.data;if(o)RiorelaxTheme.showError(a);else{$(".total-amount-text").text(r.total_amount),$("input[name=amount]").val(r.amount_raw),$(".amount-text").text(r.sub_total),$(".discount-text").text(r.discount_amount),$(".tax-text").text(r.tax_amount);var n=$(".order-detail-box").data("refresh-url");$.ajax({url:n,type:"GET",data:{coupon_code:null!==(t=$("input[name=coupon_hidden]").val())&&void 0!==t?t:$("input[name=coupon_code]").val()},success:function(e){var t=e.error,o=e.message,a=e.data;t?RiorelaxTheme.showError(o):$(".order-detail-box").html(a)},error:function(e){RiorelaxTheme.handleError(e)}})}},error:function(e){RiorelaxTheme.handleError(e)}})};$(document).on("click",".toggle-coupon-form",(function(){return $(document).find(".coupon-form").toggle("fast")})).on("click",".apply-coupon-code",(function(t){t.preventDefault();var o=$(t.currentTarget);$.ajax({url:o.data("url"),type:"POST",headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},data:{coupon_code:$("input[name=coupon_code]").val()},beforeSend:function(){o.addClass("button-loading")},success:function(t){var o=t.error,a=t.message;o?RiorelaxTheme.showError(a):(RiorelaxTheme.showSuccess(a),e())},error:function(e){RiorelaxTheme.handleError(e)},complete:function(){o.removeClass("button-loading")}})})).on("click",".remove-coupon-code",(function(t){t.preventDefault();var o=$(t.currentTarget);$.ajax({url:o.data("url"),type:"POST",headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},beforeSend:function(){o.addClass("button-loading")},success:function(t){var o=t.message;t.error?RiorelaxTheme.showError(o):(RiorelaxTheme.showSuccess(o),e())},error:function(e){RiorelaxTheme.handleError(e)},complete:function(){o.removeClass("button-loading")}})}))}));
