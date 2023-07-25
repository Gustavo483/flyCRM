function EditarFase(fase){
var btn = document.getElementById('EditarFaseBtn')
console.log(btn)
document.getElementById('id_FaseEdit').value = fase.id_Fase
document.getElementById('st_nomeFaseEdit').value = fase.st_nomeFase
btn.click()
}
function DeleteFase(fase){
var btn = document.getElementById('DeletarFaseBtn')
document.getElementById('id_FaseDelete').value = fase.id_Fase
document.getElementById('st_nomeFaseDelete').innerText = fase.st_nomeFase
btn.click()
}
