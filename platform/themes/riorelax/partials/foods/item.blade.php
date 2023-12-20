@php
$margin = $margin ?? false;
@endphp

<div @class(['single-services shadow-block mb-30', 'ser-m'=> !$margin])>
    <div class="services-thumb hover-zoomin wow fadeInUp animated">
        <a href="#">
            <img src="{{ RvMedia::getImageUrl($food->image, 'medium') }}" alt="{{ $food->name }}">
        </a>
    </div>
    <div class="services-content">
        <h4>{{ $food->name }}</h4>
        @if ($description = $food->description)
        <p class="food-item-custom-truncate food-description" title="{{ $description }}">{!! BaseHelper::clean($description) !!}</p>
        @endif
        @if ($price = $food->price)
        <div class="d-flex justify-content-between pt-5 align-items-center">
            <p class="food-item-custom-truncate food-price" title="{{ $price }}">{!! BaseHelper::clean($price) !!} c.</p>
            <button class="add-btn px-4 py-2 border-0 text-white fw-medium" onclick="addFood('{{ $food->name }}', '{{ $food->price }}', '{{ RvMedia::getImageUrl($food->image, 'medium') }}', {{$food->id}})">Добавить</button>
        </div>
        @endif
    </div>
</div>
<script>
    function addFood(foodName, foodPrice, foodImage, foodId) {
        let savedData = JSON.parse(localStorage.getItem("saved") || "[]");
        let foodCount = 1;
        if(savedData.length > 0) {
            let savedDataId = [];
            savedData.forEach((item) => {
                savedDataId.push(item.id)
            });
            if(!savedDataId.includes(foodId)) {
                let data = {
                    id: foodId,
                    foodName: foodName,
                    foodPrice: foodPrice,
                    imageUrl: foodImage,
                    foodCount: foodCount
                };
                savedData.push(data);
            } else {
                savedData.forEach((item) => {
                    if(foodId == item.id) {
                        item.foodCount = item.foodCount + 1;
                    };
                });
            };
        } else {
            let data = {
                id: foodId,
                foodName: foodName,
                foodPrice: foodPrice,
                imageUrl: foodImage,
                foodCount: foodCount
            };
            savedData.push(data);
        }
        console.log(savedData);
        localStorage.setItem("saved", JSON.stringify(savedData));
        location.reload();
    }
    // function test(params) {
    //     console.log('1');
    //     // let savedData = JSON.parse(localStorage.getItem("saved") || "[]");
    //     // let data = {
    //     //     id: foodId,
    //     //     foodName: foodName,
    //     //     foodPrice: foodPrice,
    //     //     imageUrl: imageUrl,
    //     //     foodCount: 1
    //     // };

    //     // if (cart) {
    //     //     cart.innerHTML += `<div class="d-flex justify-content-between pb-3 food-block" data-id="${data.id}">
    //     //     <div class="w-25" style="margin-right:1rem;">
	// 	//             <img src="${data.imageUrl}"
	// 	//                 alt="IMG">
	// 	//         </div>
	// 	//         <div class="w-75">
	// 	//             <div class="d-flex justify-content-between">
	// 	//                 <h5 class="text-white">${data.foodName}</h5>
	// 	//                 <button class="btn-close btn-close-white" onclick="removeFoodBlock(this)"></button>
	// 	//             </div>
	// 	//             <div class="d-flex justify-content-between align-items-center">
	// 	//                 <div>
	// 	//                     <h6 class="text-white">${data.foodPrice} сомон</h6>
	// 	//                 </div>
	// 	//                 <div class="d-flex">
	// 	//                     <div class="value-button" id="decrease" onclick="decreaseValue()" value="Decrease Value">-
	// 	//                     </div>
	// 	//                     <input type="number" id="number" value="${data.foodCount}" />
	// 	//                     <div class="value-button" id="increase" onclick="increaseValue()" value="Increase Value">+
	// 	//                     </div>
	// 	//                 </div>
	// 	//             </div>
	// 	//         </div>
	// 	//         </div>`;
    //     // }

    //     // savedData.push(data);
    //     // localStorage.setItem("saved", JSON.stringify(savedData));

    //     // location.reload();
    // }
</script>
