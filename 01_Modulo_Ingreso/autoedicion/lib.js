function insertarUploadify(id_usuario,nombre){
	ajaxgetpage('/organizacion/autoedicion/controller.php?mod=1&id_usuario='+id_usuario+'&nombre='+nombre,'detalle_usuario');
}

function eliminaFotoUsuario(pathfoto,id_usuario){
	ajaxgetpage("/organizacion/autoedicion/controller.php?mod=2&pathfoto="+pathfoto+"&id_usuario="+id_usuario,"detalle_usuario");
}

function cambiaPassword(pass,pass2){
	var passed = validarPassword(pass, {
		length:   [6, 8],
		lower:    1,
		upper:    1,
		numeric:  1,
		badWords: ["password", "qwerty", "qwasqwas", "sexo", "amor", "dios", "123456"],
		badSequenceLength: 4
	});
	
	if(pass == "" || pass2 == ""){
		alert('Debe ingresar una nueva contrase\u00f1a para poder efectuar los cambios');
	}else{
		if(pass != pass2){
			alert('Las contrase\u00f1as deben ser iguales');
		}else{
			if(passed){
				var passOk = ajaxgetResponse('/organizacion/autoedicion/controller.php?mod=31&pass='+pass);
				//alert(passOk);
				if(passOk == 1)
					ajaxgetpage('/organizacion/autoedicion/controller.php?mod=3&pass='+pass,'detalle_usuario');
				else 
					alert(passOk);
			}
			else{
				alert("La password debe tener:\nEntre 6 y 8 Caracteres\nAl menos una minuscula\nUna mayuscula\nUn numero");
			}
		}
	}
}
function validarPassword (pw, options) {
	// default options (allows any password)
	var o = {
		lower:    0,
		upper:    0,
		alpha:    0, /* lower + upper */
		numeric:  0,
		special:  0,
		length:   [0, Infinity],
		custom:   [ /* regexes and/or functions */ ],
		badWords: [],
		badSequenceLength: 0,
		noQwertySequences: false,
		noSequential:      false
	};

	for (var property in options)
		o[property] = options[property];

	var	re = {
			lower:   /[a-z]/g,
			upper:   /[A-Z]/g,
			alpha:   /[A-Z]/gi,
			numeric: /[0-9]/g,
			special: /[\W_]/g
		},
		rule, i;

	// enforce min/max length
	if (pw.length < o.length[0] || pw.length > o.length[1])
		return false;

	// enforce lower/upper/alpha/numeric/special rules
	for (rule in re) {
		if ((pw.match(re[rule]) || []).length < o[rule])
			return false;
	}

	// enforce word ban (case insensitive)
	for (i = 0; i < o.badWords.length; i++) {
		if (pw.toLowerCase().indexOf(o.badWords[i].toLowerCase()) > -1)
			return false;
	}

	// enforce the no sequential, identical characters rule
	if (o.noSequential && /([\S\s])\1/.test(pw))
		return false;

	// enforce alphanumeric/qwerty sequence ban rules
	if (o.badSequenceLength) {
		var	lower   = "abcdefghijklmnopqrstuvwxyz",
			upper   = lower.toUpperCase(),
			numbers = "0123456789",
			qwerty  = "qwertyuiopasdfghjklzxcvbnm",
			start   = o.badSequenceLength - 1,
			seq     = "_" + pw.slice(0, start);
		for (i = start; i < pw.length; i++) {
			seq = seq.slice(1) + pw.charAt(i);
			if (
				lower.indexOf(seq)   > -1 ||
				upper.indexOf(seq)   > -1 ||
				numbers.indexOf(seq) > -1 ||
				(o.noQwertySequences && qwerty.indexOf(seq) > -1)
			) {
				return false;
			}
		}
	}

	// enforce custom regex/function rules
	for (i = 0; i < o.custom.length; i++) {
		rule = o.custom[i];
		if (rule instanceof RegExp) {
			if (!rule.test(pw))
				return false;
		} else if (rule instanceof Function) {
			if (!rule(pw))
				return false;
		}
	}

	// great success!
	return true;
}