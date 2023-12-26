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
            <p class="food-item-custom-truncate food-price" title="{{ $price }}">{!! BaseHelper::clean($price) !!} smn</p>
            <button class="add-btn px-4 py-2 border-0 text-white fw-medium" onclick="addFood('{{ $food->name }}', '{{ $food->price }}', '{{ RvMedia::getImageUrl($food->image, 'medium') }}', {{$food->id}})">Add</button>
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
</script>
