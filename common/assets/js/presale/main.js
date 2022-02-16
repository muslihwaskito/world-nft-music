function submit(){
    var email = document.querySelector('[name="email"]').value;
    var password = document.querySelector('[name="password"]').value;
    if (email == '' || password == '') {
        Swal.fire(
            'Error Alert',
            'Username or password can\'t empty',
            'error'
        )
        return false;
    }

    const data = {
        email: email,
        password: password
    };

    $.ajax({
        type: "post",
        url: "service/login.php",
        data: data,
        success: function (response) {
            const result = JSON.parse(response);
            if (result.status == 200) {
                document.querySelector('#fire-1').style.display = 'block';
                document.querySelector('#fire-2').style.display = 'block';
                document.querySelector('#fire-3').style.display = 'block';
                Swal.fire({
                    title: '<strong>Congratulation!!!</strong>',
                    icon: 'success',
                    html:
                        'You can use this code <b>'+ result.data.token +'</b> to buy presale.',
                    showCloseButton: true,
                    showCancelButton: false,
                    focusConfirm: false,
                    confirmButtonText:
                        '<i class="fa fa-copy"></i> Copy Code'
                }).then((res) => {
                    if (res.isConfirmed) {
                        // copy input
                        var input = document.createElement('input');
                        const token = JSON.parse(response).data.token
                        input.setAttribute('value', token);
                        document.body.appendChild(input);
                        input.select();
                        var result = document.execCommand('copy');
                        document.body.removeChild(input);
                        Swal.fire({
                            icon: 'success',
                            title: 'Text copied to clipboard',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                })
            } else {
                Swal.fire(
                    'Error Alert',
                    result.message,
                    'error'
                )
            }
            
        }
    });
}

function submitRegis(){
    var email = document.querySelector('[name="email_regist"]').value;
    var password = document.querySelector('[name="password_regist"]').value;
    var re_password = document.querySelector('[name="re_password_regist"]').value;
    console.log(email, password,re_password)
    if (email == '' || password == '' || re_password == '') {
        Swal.fire(
            'Error Alert',
            'Email or password can\'t empty',
            'error'
        )
        return false;
    }

    if (password !== re_password) {
        Swal.fire(
            'Error Alert',
            'Password doesn\'t match!!!',
            'error'
        )
        return false;
    }

    const data = {
        email: email,
        password: password
    };

    $.ajax({
        type: "post",
        url: "service/register.php",
        data: data,
        success: function (response) {
            const result = JSON.parse(response);
            if (result.status == 200) {
                document.querySelector('[name="email_regist"]').value = '';
                document.querySelector('[name="password_regist"]').value = '';
                document.querySelector('[name="re_password_regist"]').value = '';
                Swal.fire(
                    'Congratulation!!!',
                    result.message,
                    'success'
                );
            } else {
                Swal.fire(
                    'Error Alert',
                    result.message,
                    'error'
                )
            }
            
        }
    });
}