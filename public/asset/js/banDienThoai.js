//hàm xử lý hiệu ứng khi thêm
let btnThemVaoGio = document.querySelectorAll('.btn-them-vao-gio')
let count = 0
function themGioHang(){
    count++
    console.log(count)
    let soLuongItem = document.querySelector('#gio-hang')
    if(count === 1){
        let icon = document.querySelector('.gio-hang > i')
        icon.style.color = 'green'
        soLuongItem.style.backgroundColor = 'green'
    }
    else if(count === 0 ){
        let icon = document.querySelector('.gio-hang > i')
        icon.style.color = 'black'
        soLuongItem.style.backgroundColor = 'black'
    }
    soLuongItem.innerText = count
}
for(let i of btnThemVaoGio){
    i.onclick = themGioHang
}

// event best seller
const btnPre = document.querySelector('#btn-pre')
const btnNext = document.querySelector('#btn-next')
let percent = 0
let gap = 0

// dư sản phầm --> không cho animation
const maxCount = 2
function dichChuyenSangTrai(){
    if(gap < maxCount){
        percent+=100
        gap+=1
        let listSP = document.querySelectorAll('.san-pham')

        for(let i of listSP){
            i.style.transform = `translateX(calc(-${percent}% - ${gap}rem))`
        }
    }
}
    
function dichChuyenSangPhai(){
    if(gap <= maxCount && gap !== 0){
        percent-=100
        gap-=1
        let listSP = document.querySelectorAll('.san-pham')

        for(let i of listSP){
            i.style.transform = `translateX(calc(-${percent}% - ${gap}rem))`
        }
    }
}
function bestSalerAni(index){
    let listSP = document.querySelectorAll('.san-pham')

    for(let i of listSP){
        i.style.transform = `translateX(calc(-${percent}% - ${gap}rem))`
    }
}
function animation2Giay(index){
   bestSalerAni(index)
}

// add event 
btnNext.onclick = (e)=>{
    dichChuyenSangTrai()
}
btnPre.addEventListener('click',(e)=>{
   dichChuyenSangPhai()
})
let timerTemp = setInterval(()=>{
    animation2Giay()
},2000)

// js trang chi tiet san pham
const btn = document.querySelector('#product-info')
function toggleProductInfo(button){
    if(button.innerText == '+'){
        let info = document.querySelector('#chi-tiet-mo-ta')
        info.style.height = '150px'
        button.innerText = '-'
    }
    else{
        let info = document.querySelector('#chi-tiet-mo-ta')
        info.style.height = '0px'
        button.innerText = '+'
    }
    
}
btn.onclick = (e) => {
    toggleProductInfo(e.target)
}