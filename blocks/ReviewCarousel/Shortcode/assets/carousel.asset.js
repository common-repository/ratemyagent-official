window.addEventListener("load",(function(){[{selector:".rma-full-review-carousel",config:{slidesPerView:1,spaceBetween:10,grabCursor:!0}},{selector:".rma-multi-slide-carousel",config:{slidesPerView:1,spaceBetween:10,grabCursor:!0,breakpointsBase:"container",breakpoints:{320:{slidesPerView:1,spaceBetween:10},640:{slidesPerView:2,spaceBetween:10},960:{slidesPerView:3,spaceBetween:20},1200:{slidesPerView:4,spaceBetween:20}}}}].forEach((({selector:e,config:i})=>{document.querySelectorAll(e).forEach((e=>((e,i)=>{const r=`#${e.id}`,s=`.${e.id}-container`,n={...i,navigation:{nextEl:`${s} .swiper-button-next`,prevEl:`${s} .swiper-button-prev`},pagination:{el:`${s} .swiper-pagination`,clickable:!0}};new Swiper(r,n)})(e,i)))}))}));