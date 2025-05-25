var mainimg=document.querySelector('img')
var images=["images/img1.jpg","images/img2.avif","images/img3.jpg","images/img4.jpg"];
var num=0;
const auto =true
const IntervalTime=5000;
let slideInterval

function next(){
    num++
    if(num>=images.length){
        num=0;
        mainimg.src=images[num]
    }
    else{
        mainimg.src=images[num]
    }
}

function back(){
    num--
    if(num<0){
        num=images.length-1
        mainimg.src=images[num]
    }
    else{
        mainimg.src=images[num]
    }
}   

if(auto){
    slideInterval=setInterval(next,IntervalTime)
}