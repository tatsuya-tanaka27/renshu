let slide;
let image;
let TimeID;
let timeID;
let cnt=0;
let cnt2=1;
let posi1;
let posi2;
let flag=true;
let max_width;
let max_height;
let controll;
let btn;
let stop_time=2000;//画像の停止時間
let idou_time=10;
let idou__kyori=5;//画像が上記idou_time＋処理時間で5px移動
let keika_time;
//見せる画像を設定する
function disp(){
	cnt2 = cnt + 1;
	//一番最後の画像だった場合は最初の画像に戻る
	if(cnt2===image.length){
		cnt2=0;
	}
	image[cnt2].style.display="list-item";
	posi1=0;
	posi2=max_width; //max_width分、横にずれていく
	slider();
	timeID=setTimeout(disp,keika_time+stop_time);
}
//画像をスライドさせていく
function slider(){
	TimeID=setTimeout(slider,idou_time);
	posi1-=idou__kyori;
	posi2-=idou__kyori;
	image[cnt].style.left=posi1+"px";
	image[cnt2].style.left=posi2+"px";
	if(posi2<=5){
		image[cnt2].style.left="0px";
		btn[cnt].style.opacity="1.0";
		btn[cnt2].style.opacity="0.5";
		image[cnt].style.display="none";
		cnt++;
		if(cnt===image.length){
			cnt=0;
		}
		clearTimeout(TimeID);
	}
}
window.onload=function(){
	let con="<ul id='controll'>";
	max_width=0;
	max_height=0;
	slide=document.getElementById("slide")
	image = slide.getElementsByTagName("li");
	//スライド画像の中で一番大きな画像サイズに合わせてサイズ調整する
	for(i=0;i<image.length;i++){
		let width=image[i].getElementsByTagName("img")[0].naturalWidth;
		let height=image[i].getElementsByTagName("img")[0].naturalHeight;
		if(max_width<width){
			max_width=width;
		}
		if(max_height<height){
			max_height=height;
		}
		con+="<li onclick='idou("+i+")'>●</li>";
	}
	//nextとbackのマークを計算して表示する
	con+="</ul><div id='back' onclick='idou(cnt-1)'></div><div id='next' onclick='idou(cnt+1)'></div>";
	slide.insertAdjacentHTML ("afterend",con);
	controll=document.getElementById("controll");
	btn=controll.getElementsByTagName("li");
	controll.style.width=max_width+"px";
	slide.style.width=max_width+"px";
	slide.style.height=max_height+"px";
	image[1].style.left=max_width+"px";
	let clientRect=slide.getBoundingClientRect() ;
	let slide_x=window.pageXOffset+clientRect.left ;
	let slide_y=window.pageYOffset+clientRect.top ;
	const next=document.getElementById("next");
	const back=document.getElementById("back");
	next.style.left=(slide_x+max_width-30)+"px";
	back.style.left=(slide_x-20)+"px";
	next.style.top=((slide_y+max_height)/2-25)+"px";
	back.style.top=((slide_y+max_height)/2-25)+"px";
	keika_time=(Math.floor(max_width/idou__kyori))*(idou_time+5);//5は処理時間5ms目安
	timeID=setTimeout(disp,stop_time);
}
//画像を切り替える
function idou(x){
	clearTimeout(TimeID);
	clearTimeout(timeID);
	if(x<0){
		x=image.length-1;
	}
	if(x>=image.length){
		x=0;
	}
	image[x].style.left="0px";
	image[cnt].style.display="none";
	image[cnt2].style.display="none";
	image[x].style.display="list-item";
	btn[cnt].style.opacity="1";
	btn[x].style.opacity="0.5";
	let y=x+1;
	if(y==image.length){
		y=0;
	}
	image[y].style.left=max_width+"px";
	image[y].style.display="list-item";
	cnt=x;
	timeID=setTimeout(disp,stop_time);
}
