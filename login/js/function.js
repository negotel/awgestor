function login(token) {
    $("#btn_login").prop("disabled", !0), $("#btn_login").html('<i class="fa fa-refresh fa-spin" ></i> &nbsp;&nbsp;&nbsp; Aguarde');
    var e = $("#email").val(),
        n = $("#senha").val();
    $.post("../control/control.login.php", {
        email: e,
        senha: n,
        token: token
    }, function(e) {
        
        var obj = JSON.parse(e);
        
        if(obj.erro){
            $("#msg").addClass("text-white");
            $("#msg").html(obj.msg);
            $("#btn_login").prop("disabled", false);
            $("#btn_login").html("Entrar");
            grecaptcha.reset();

        }else{
            $("#msg").html("Redirecionando...");
            location.href = "../painel";
        }

    })
}

function create() {
    $("#btn_create").prop("disabled", !0), $("#btn_create").html("Aguarde..");
    
    
    var ddiObject = iti.getSelectedCountryData();
    var ddi = ddiObject.dialCode;
    
    var e = new Object;
    e.nome = $("#nome").val(), e.email = $("#email").val(), e.telefone = $("#telefone").val(), e.senha = $("#senha").val(), e.ddi = ddi;
    var n = JSON.stringify(e);
    $.post("../control/control.create_conta.php", {
        dados: n
    }, function(e) {
        var n = jQuery.parseJSON(e);
        n.erro ? 1 == n.type ? (alert(n.msg), location.href = "login") : (alert(n.msg), $("#btn_create").prop("disabled", !1), $("#btn_create").html("Criar")) : location.href = "../painel"
    })
}
$(document).ready(function() {
    var e = function(e) {
            return 11 === e.replace(/\D/g, "").length ? "(00) 00000-0000" : "(00) 0000-00009"
        },
        n = {
            onKeyPress: function(n, t, a, o) {
                a.mask(e.apply({}, arguments), o)
            }
        };
    $("#telefone").mask(e, n)
}), $(document).on("keyup", "#senha", function(e) {
    13 == e.which && login()
});