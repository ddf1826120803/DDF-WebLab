let myForm = document.getElementById('myForm');
let createTable = document.getElementById('createTable');
let commit = document.getElementById('commit1');
var tables = new Array();
function select1(){
	let mySelect = document.getElementById('mySelect');
	var grade = mySelect.options[mySelect.selectedIndex].value;
    selectClick(grade);
}
function selectClick(s){
	switch(s){
		case "CREATE TABLE":createTable1();break;
		case "SELECT ONE":unShowCommit();break;
		case "ADD ROW":createTableCell();break;
		case "DELETE ROW":deleteRow();break;
		case "DELETE TABLE":deleteTable1();break;
		default: return 0;}
}
function unShowCommit(){
	if(!commit.classList.contains('unShow')){
				commit.classList.toggle('unShow');}
}
function unShowCommit(){
	if(commit.classList.contains('unShow')){
				commit.classList.toggle('unShow');}
}
// 创建表格设置单元
function createTable1(){
	var input2,input1;
	let select2 = document.getElementById('mySelect2');
	if(select2.options.length==0){
		//为第二格下拉列表添加默认下拉表项
		let defaultL = document.createElement('option');
		defaultL.setAttribute('value', "SELECT");
		defaultL.id="defaultL";
		defaultL.appendChild(document.createTextNode('SELECT'));
		select2.appendChild(defaultL);
	}
	// 判断是否为初始化创建表格操作
	if(myForm.childNodes.length===2){
		// 表格名设置
		input1 = document.createElement('input');
		input1.setAttribute("placeholder","Table Name");
		input1.setAttribute("type", "text");
		input1.id="tableName";
		input1.className="step1";
		// 表格列数设置
		input2 = document.createElement('input');
		input2.setAttribute("placeholder","Columns Numbers");
		input2.setAttribute("type", "number");
		input2.className="step1";
		input2.id="inputNumber";
		myForm.insertBefore(input1,commit);
		myForm.insertBefore(input2,commit);
	}
	else{
		// 创建表格时删除多余的input
		while (myForm.childNodes.length!==4) {
			myForm.removeChild(myForm.childNodes[myForm.childNodes.length-2]);
		}
		// 显示表格名与表格列数位置input
		displayCreateTable();
	}
	// 保证显示或消失表格名与表格列数位置input
	function displayCreateTable(){
		let inputD = document.getElementById('tableName');
		inputD.value="";
		let inputD1 = document.getElementById('inputNumber');
		inputD1.value="";
		if(inputD.classList.contains('unShow')){
		inputD.classList.toggle('unShow');
		inputD1.classList.toggle('unShow');}
	}
	input1.onchange=function(){
		if(input1.value===""){
			if(!commit.classList.contains('unShow')){
				commit.classList.toggle('unShow');
			}
		}
	}
	// 设置表格列数并显示相应数量的表头属性input
	input2.onchange=function() {
		while (myForm.childNodes.length!==4) {
			myForm.removeChild(myForm.childNodes[myForm.childNodes.length-2]);
		}
		let inputN = Number(input2.value);
		for(var i=0;i<inputN;i++){
			let inputArr = document.createElement('input');
			inputArr.setAttribute('type',"text");
			inputArr.setAttribute("placeholder","thead"+(1+i));
			inputArr.className="step1";
			myForm.insertBefore(inputArr,commit);
		} 
		// 判断列数为正数
		if(inputN>0){commit.classList.add('showCommit');unShowCommit();}
		else{commit.classList.remove('showCommit');}
	}
}
// commit事件
commit.addEventListener("click",function(){
	let mySelect = document.getElementById('mySelect');
	var grade = mySelect.options[mySelect.selectedIndex].value;
		if(grade==="CREATE TABLE"){
			// 判断表格名为空
			if(document.getElementById('tableName').value===""){
				alert("表格名不能为空");}
			else{
				let inputN = Number(document.getElementById('inputNumber').value);
				// 判断表头为空
				for(let i=0;i<inputN;i++){
					if(myForm.childNodes[3+i].value===""){
						alert("表头不能为空");
						return;
					}
				}
				let form2 = document.getElementById('myForm2');
				// 为第二个下拉列表添加下拉项
				let select2 = document.getElementById('mySelect2');
				let option1 = document.createElement('option');
				option1.setAttribute("value", document.getElementById('tableName').value);
				option1.appendChild(document.createTextNode(document.getElementById('tableName').value));
				option1.setAttribute("selected",true);
				let defaultL = document.getElementById('defaultL');
				select2.insertBefore(option1,defaultL);
				// 添加表格
				let table1 = document.createElement('table');
				table1.id=document.getElementById('tableName').value;
				let thead = document.createElement('thead');
				// 添加表单元
				table1.appendChild(thead);
				let tbody1 = document.createElement('tbody');
				tbody1.id="tbody2";
				table1.appendChild(tbody1);
				thead.insertRow(0);
				for(var i=0;i<inputN;i++){
					thead.rows[0].insertCell(i);
					thead.rows[0].cells[i].appendChild(document.createTextNode(myForm.childNodes[3+i].value));
				}
				form2.appendChild(table1);
				// 将表格添加到表格组中
				tables[tables.length]=table1;
				if(tables.length>1){
					tables[tables.length-2].classList.toggle('unShow');
				}
			}
		}
		// 调用ADD ROW方法
		else if(grade==="ADD ROW"){createTableCell2();}
		else if(grade==="DELETE ROW"){	deleteRow2();}
		else if(grade==="DELETE TABLE"){deleteTable2();}
},false);
// 添加对应表格的行
function createTableCell(){
	let myFormLength = Number(myForm.length);
	unshowTableNameInput();
	for(let i=3;i<myFormLength-1;i++){
		myForm.removeChild(myForm.childNodes[myForm.length-2]);
	}
	// 获取第二个下拉表选中项
	let mySelect = document.getElementById('mySelect2');
	let grade = Number(mySelect2.selectedIndex);
	// 获取需添加表单元数量
	let inputN = Number(tables[grade].tHead.rows[0].cells.length);
	for(var i=0;i<inputN;i++){
		let inputCell = document.createElement('input');
		// 获得表格集合，根据下拉列表选中项，获取相应的表头元素
		let inputCellP = tables[grade].tHead.rows[0].cells[i].innerHTML;
		inputCell.setAttribute('placeholder',inputCellP);
		inputCell.setAttribute('type',"text");
		inputCell.className="step1";
		myForm.insertBefore(inputCell,commit);
	}
}
// 让表格名设置与列数设置input消失
function unshowTableNameInput(){
	let inputD = document.getElementById('tableName');
	let inputD1 = document.getElementById('inputNumber');
	if(!inputD.classList.contains('unShow')){
		inputD.classList.toggle('unShow');
		inputD1.classList.toggle('unShow');
	}
}
// 创建表格单元
function createTableCell2() {
	// 获取第二个下拉列表选中项
	let mySelect = document.getElementById('mySelect2');
	var grade = Number(mySelect.selectedIndex);
	let inputN = Number(tables[grade].tHead.rows[0].cells.length);
	// 对应表格tbody的长度
	let rowsLength = Number(tables[grade].tBodies[0].rows.length);
	tables[grade].tBodies[0].insertRow(rowsLength);
	for(var i=0;i<inputN;i++){
		let myFormLength = Number(myForm.length);
		let cellContent = myForm.childNodes[3+i].value;
		tables[grade].tBodies[0].rows[rowsLength].insertCell(i);
		tables[grade].tBodies[0].rows[rowsLength].cells[i].appendChild(document.createTextNode(cellContent));
	}
}
// 第二个下拉列表事件
function select2(){
	let mySelect = document.getElementById('mySelect2');
	var grade = Number(mySelect.selectedIndex);
    selectClick2(grade);
}
// 设置表格事件
function selectClick2(s){
	// 选中那个表格就进行表格切换
	for(var i=0;i<tables.length;i++){
		if(!tables[i].classList.contains('unShow')){
			tables[i].classList.toggle('unShow');
		}
	}
	tables[s].classList.toggle('unShow');
	let mySelect = document.getElementById('mySelect');
	var grade = mySelect.options[mySelect.selectedIndex].value;
	if(grade==="ADD ROW"){createTableCell();}
	else if(grade==="DELETE ROW"){deleteRow();}
}
// 删除对应表格行
function deleteRow(){
	// 清除相应内容
	let myFormLength = Number(myForm.length);
	for(let i=3;i<myFormLength-1;i++){
		myForm.removeChild(myForm.childNodes[myForm.length-2]);
	}
	unshowTableNameInput();
	if(commit.classList.contains('unShow')){
		commit.classList.toggle('unShow');
	}
	// 获取第二个下拉表选中项
	let mySelect = document.getElementById('mySelect2');
	let grade = Number(mySelect2.selectedIndex);
	// 获取需添加表单元数量
	let inputN = Number(tables[grade].tHead.rows[0].cells.length);
	for(var i=0;i<inputN;i++){
		let inputCell = document.createElement('input');
		// 获得表格集合，根据下拉列表选中项，获取相应的表头元素
		let inputCellP = tables[grade].tHead.rows[0].cells[i].innerHTML;
		inputCell.setAttribute('placeholder',inputCellP);
		inputCell.setAttribute('type',"text");
		inputCell.className="step1";
		myForm.insertBefore(inputCell,commit);
	}
 }
 function deleteRow2(){
 	// 获取第二个下拉表选中项
	let mySelect = document.getElementById('mySelect2');
	let grade = Number(mySelect2.selectedIndex);
	let find=0;
	let deleteTableRowsL = Number(tables[grade].tBodies[0].rows.length);
	let deleteContent,deleteTableContent;
	for(var i=0;i<deleteTableRowsL;i++){
		a:for(var a=3;a<myForm.length-1;a++){
			deleteContent = String(myForm.childNodes[a].value);
			deleteTableContent = String(tables[grade].tBodies[0].rows[i].cells[a-3].innerHTML);
			if(deleteContent===deleteTableContent){
				find++;
			}
			else{
				find=0;
				break a;
			}
		}
		if(find===(myForm.length-4)){tables[grade].tBodies[0].deleteRow(i);}
	}
 	
 	if(find!==(myForm.length-4)){
 		alert(find+"");
 		alert("没有匹配项");
 		tables[grade].tBodies[0].deleteRow(0);
 	}
 }
 // 删除表格
 function deleteTable1(){
 	alert("WARNING: You cannot undo this action!");
 }
 function deleteTable2(){
 	// 获取第二个下拉表选中项
	let mySelect = document.getElementById('mySelect2');
	let grade = Number(mySelect.selectedIndex);
	//删除表格
	tables[grade].classList.toggle('unShow');
	tables.splice(grade,1);
	mySelect.removeChild(mySelect.childNodes[grade]);
	if(mySelect.childNodes.length<2){
		alert("即到底");
	}
	else{
		tables[0].classList.toggle('unShow');
	}
 }
