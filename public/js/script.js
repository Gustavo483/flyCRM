function vizualizarEmpresa(id_empresa){
    var bltEmpresa = document.getElementById(id_empresa)
    bltEmpresa.click()
}
function abrirDiv(id_elemento, cabecalho){
    var div = document.getElementById(id_elemento)
    var divCabecalho = document.getElementById(cabecalho)
    console.log(divCabecalho)
    var btn = document.getElementById(cabecalho+'Desenho')
    btn.classList.toggle('backgroud233')
    div.classList.toggle('none')
    divCabecalho.classList.toggle('divCabecalho')
    divCabecalho.classList.toggle('divCabecalho2')
}
function EditarUsuario(usuario){
    var btn = document.getElementById('EditarUsuarioBtn')
    console.log(btn)
    document.getElementById('id_user').value = usuario.id
    document.getElementById('nameEdit').value = usuario.name
    document.getElementById('emailEdit').value = usuario.email
    document.getElementById('st_setorEdit').value = usuario.st_setor
    btn.click()
}
function DeleteUsuario(usuario){
    var btn = document.getElementById('DeletarUsuarioBtn')
    document.getElementById('id_userDelete').value = usuario.id
    document.getElementById('nameUsario').innerText = usuario.name
    btn.click()
}

function DeleteStatus(status){
    var btn = document.getElementById('DeletarStatusBtn')
    document.getElementById('id_statusDelete').value = status.id
    document.getElementById('StTituloDelete').innerText = status.st_titulo
    btn.click()
}
