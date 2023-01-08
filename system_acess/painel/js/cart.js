function checkout(t) {
    $(".button_pay").prop("disabled", !0), $("#button_" + t).html('<i class="fa fa-spinner fa-spin"></i> Aguarde'), $.post("../control/control.control_checkout.php", {
        stage: "1",
        id: t
    }, function(t) {
        var o = JSON.parse(t);
       // o.erro ? (alert(o.msg), location.href = "") : ($("#btn_mp").attr("href", o.msg), $("#modal_payment").modal("show"))
        location.href="pagamentos";
    });
   
}


function modal_payment_p(t) {
    $("#btn_pay_" + t).prop("disabled", !0), $("#btn_pay_" + t).html('<i class="fa fa-spinner fa-spin"></i>'), $("#btn_pay_" + t).attr("title", "Aguarde por gentileza"), $.post("../control/control.control_checkout.php", {
        stage: "2",
        id: t
    }, function(o) {
        console.log(o);
        var a = JSON.parse(o);
        a.erro ? (alert(a.msg), location.href = "") : ($("#btn_mp").attr("href", a.msg), $("#modal_payment").modal("show"), $("#btn_pay_" + t).prop("disabled", !1), $("#btn_pay_" + t).html("Pagar"))
    })
}
$("#modal_payment").on("hide.bs.modal", function(t) {
    location.href = "pagamentos"
});