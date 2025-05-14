function connexion(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: '../Controleurs/controleur.php',
        data: {
            action: 'login',
            pseudo: $('#loginPseudo').val(),
            password: $('#loginPassword').val()
        },
        success: function (response) {
           // alert("Connexion : " + response);
            switch (response)
            {
                case "user":
                    window.location.href = "jeu.php";
                    break;
                case "admin":
                    window.location.href = "admin_categories.php";
                    break;
                default :
                    showMessage("Login et/ou mot de passe incorrect", "danger");
            }
        }
    });
}
function showMessage(message, type) {
    const msgBox = $('#messageBox');
    msgBox.removeClass('d-none alert-success alert-danger alert-info alert-warning')
            .addClass(`alert-${type}`)
            .text(message)
            .fadeIn();

    setTimeout(() => {
        msgBox.fadeOut(() => {
            msgBox.addClass('d-none').text('');
        });
    }, 4000); // 4 secondes
}

function inscription(e) {
    e.preventDefault();

    const password = $('#registerPassword').val();
    const confirm = $('#registerPasswordConfirm').val();

    if (password !== confirm) {
        showMessage("Les mots de passe ne correspondent pas.", "danger");

    } else
    {

        $.ajax({
            type: 'POST',
            url: '../Controleurs/controleur.php',
            data: {
                action: 'register',
                pseudo: $('#registerPseudo').val(),
                password: password
            },
            success: function (response) {
                showMessage("Inscription : " + response, "success");
                switch (response)
            {
                case "user":
                    window.location.href = "jeu.php";
                    break;
                case "admin":
                    window.location.href = "admin_categories.php";
                    break;
                default :
                    showMessage("Ce pseudo existe déjà", "danger");
            }
            },
            error: function () {
                showMessage("Erreur lors de l'inscription.", "danger");
            }
        });
    }
}


$(document).ready(function () {
    $('#showLogin').click(function () {
        $('#registerForm').hide();
        $('#loginForm').show();
    });

    $('#showRegister').click(function () {
        $('#loginForm').hide();
        $('#registerForm').show();
    });

    $('#formLogin').submit(connexion);

    $('#formRegister').submit(inscription);
});
