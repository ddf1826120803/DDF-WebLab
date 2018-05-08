/*
* @Author: ddf
* @Date:   2018-05-04 16:04:38
* @Last Modified by:   ddf
* @Last Modified time: 2018-05-04 18:43:29
*/

for(var a=0;a<countries.length;a++){
	// 创建背景
	let section0 = document.getElementById("section0");
	let section1 = document.createElement("div");
	section1.classList.add("item");

	// 添加标题
	let section1_h1 = document.createElement("h2");
	section1_h1.classList.add("h2");
	section1_h1.innerHTML= countries[a].name;
	section1.appendChild(section1_h1);
	//副标题
	let section1_h2 = document.createElement("h3");
	section1_h2.classList.add("h3");
	section1_h2.innerHTML= countries[a].continent;
	section1.appendChild(section1_h2);
	//副内容
	let div1 = document.createElement("div");
	div1.classList.add("inner-box");
	let p = document.createElement("p");
	p.innerHTML="Cities";
	p.classList.add("p");
	div1.appendChild(p);

	//链接区
	let ul = document.createElement("ul");
	ul.classList.add("ul");
	for(var i = 0;i<countries[a].cities.length;i++){
		let  li = document.createElement("li");
		li.innerHTML=countries[a].cities[i];
		ul.appendChild(li);
	}
	div1.appendChild(ul);
	section1.appendChild(div1);

	//图片区
	let div2 = document.createElement("div");
	div2.classList.add("inner-box");
	let title = document.createElement("h3");
	title.classList.add("h3");
	title.innerHTML="Popular Photos";
	div2.appendChild(title);
	for(var i=0;i<countries[a].photos.length;i++){
		let img = document.createElement("img");
		img.classList.add("photo");
		img.src="images/"+countries[a].photos[i];
		div2.appendChild(img);
	}
	section1.appendChild(div2);

	//按钮
	let btn = document.createElement("button");
	btn.classList.add("button");
	btn.innerHTML="Visit";
	section1.appendChild(btn);

	section0.appendChild(section1);

}