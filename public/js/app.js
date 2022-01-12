function confirmEmptyCart() {
	//Siempre que una acción no se pueda deshacer hay que pedir confirmación al usuario
	if (confirm('¿Seguro que desea vaciar el carrito? ')) return true;
	else return false;
}
