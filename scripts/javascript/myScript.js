var spFJsons;

function initialize(){
	sessionStorage["nextIndex"]="0";
}

function submitImageForm(){
	var select_elem=document.getElementById("other_forms");
	var opts = select_elem.options;
	var words="";
	for (i = 0; i < opts.length; i++){
		// if (opts[i].selected)
			// words = words + opts[i].text + ";\t";
		if (!opts[i].selected)
			delete spFJsons[opts[i].text];
	}
	words = JSON.stringify(spFJsons);
	document.forms['mainForm']['all_words'].value = words;
	document.forms['mainForm'].submit();
}

function validate_word(word){
	var re_exp = XRegExp("(^\\p{L}+$)|(^\\p{L}+([\-,']+\\p{L}+)*(s')*$)");
	return re_exp.test(word);
	}

function getSpanishForms() {	
    var sing = document.forms['mainForm']['word'].value.trim();
	if (!validate_word(sing)) return;	
    var slen = sing.length;
	if (slen==0)
		return;
	// 
	var select_elem=document.getElementById("other_forms");
	$('#other_forms').find('option').remove();

	var xmlhttp = new XMLHttpRequest();
	var spForms;
	var opt;
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {		
		spFJsons=this.response;
		for ( spForm in spFJsons ){	
			opt = document.createElement("option");
			opt.text = spForm;
			select_elem.add(opt);
		}		

		// spForms=this.responseText.split(", ");		
		// for (i = 0; i < spForms.length; i++){
			// opt = document.createElement("option");
			// opt.text = spForms[i];
			// select_elem.add(opt);			
		// }			

      }
    };
	xmlhttp.open("GET", "scripts/php/spanish_forms.php?word=" + sing, true);
	xmlhttp.responseType='json'; 
    xmlhttp.send();
}

function addToReplacementList() {
	var idx=sessionStorage["nextIndex"];
	var entry = document.getElementById('listEntry').innerHTML.trim();
	sessionStorage[idx]=entry;
	sessionStorage["nextIndex"]= parseInt(idx)+1 + "";
}
function removeFromReplacementList() {
	var listObj = document.forms['listForm']['listreplacements'];
	var delidx = listObj.selectedIndex;
	listObj.remove(delidx);
	
	var lastIdx = sessionStorage["nextIndex"]-1;
	sessionStorage[delidx] = sessionStorage[lastIdx];
	sessionStorage.removeItem(lastIdx);
	sessionStorage["nextIndex"]= parseInt(lastIdx) + "";
	
	var imgElement=document.getElementById("preview");
	imgElement.src="";
	
	document.getElementById('removeButton').disabled=true;
}
function reflect(){
	alert(document.forms['mainForm']['imagelocation'].files[0].name);
}
function populateList(){
    var listObj = document.forms['listForm']['listreplacements'];
	var option;
	var imax= parseInt(sessionStorage["nextIndex"]);
	var i;
	var jsonobj;
	for (i = 0; i < imax; i++) {
		option = document.createElement('option');
		option.text = '';
		jsonobj = JSON.parse(sessionStorage[i+""]);
		for ( item in jsonobj){
			if (jsonobj[item] != 'image')
				option.text = option.text + item + "; ";
		}
		listObj.add(option);
	} 

	if (listObj.clientWidth==0){
		window.location.reload();
	}
}
function previewCurrentImage(){
	var listObj = document.forms['listForm']['listreplacements'];
	var jsonobj = JSON.parse(sessionStorage[listObj.selectedIndex+""]);
	var imgName= Object.keys(jsonobj).find(key => jsonobj[key] === "image");
	var imgElement=document.getElementById("preview");
	imgElement.src="uploads/"+imgName;
}
function finalize(){
	var iter;	
	var optstring="";
	// var opts=document.forms['listForm']['listreplacements'].options;
	var opts = sessionStorage;
	var imax= parseInt(sessionStorage["nextIndex"]);
	for (iter=0; iter< imax; iter++){
		// optstring+=opts[iter].text+"*";
		optstring+=opts[iter+""]+"*";
	}	
	document.getElementById("finallist").value=optstring;
	document.getElementById("listForm").submit(); 
}