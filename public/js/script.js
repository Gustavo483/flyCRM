function vizualizarEmpresa(id_empresa){
    var bltEmpresa = document.getElementById(id_empresa)
    bltEmpresa.click()
}
function abrirDiv(id_elemento, cabecalho){
    var div = document.getElementById(id_elemento)
    var divCabecalho = document.getElementById(cabecalho)
    var btn = document.getElementById(cabecalho+'Desenho')
    var text = document.getElementsByClassName('divUsuariosEmpresaText')
    btn.classList.toggle('backgroud233')
    div.classList.toggle('none')
    divCabecalho.classList.toggle('divCabecalho2')
}
