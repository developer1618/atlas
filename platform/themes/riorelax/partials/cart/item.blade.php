<div class="grid row col-3 bg-dark flex-column justify-content-between">
    <div>
        <h3 class="text-white py-4">Basket</h3>
        <div>
            <div class="d-flex">
                <img src="http://atlashoteldushanbe.com/storage/shashlik.jpg" class="img-fluid rounded-top w-25"
                    alt="IMG">
            </div>
            <div class="d-flex justify-content-between">
                <h5 class="text-white">{{ $food->name }}</h5>
            </div>
            <div class="d-flex justify-content-between">
            @if ($price = $food->price)
                <h6 class="text-white">{!! BaseHelper::clean($price) !!} c.</h6>
            @endif
                <div class="col-lg-5">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button class="add-btn quantity-left-minus btn bg-white btn-number rounded-0">
                                <span class="glyphicon glyphicon-minus">-</span>
                            </button>
                        </span>
                        <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1" min="1" max="100">
                        <span class="input-group-btn">
                            <button class="add-btn quantity-right-plus btn bg-white btn-number rounded-0">
                                <span class="glyphicon glyphicon-plus">+</span>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pb-4">
        <button class="add-btn px-4 py-2 w-100 border-0 text-white fw-medium">Order <span>190.00</span>smn</button>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script>
$(document).ready(function () {

    var quantitiy = 0;
    $('.quantity-right-plus').click(function (e) {

    // Stop acting like a button
    e.preventDefault();
    // Get the field name
    var quantity = parseInt($('#quantity').val());

    // If is not undefined

    $('#quantity').val(quantity + 1);


    // Increment

    });

    $('.quantity-left-minus').click(function (e) {
    // Stop acting like a button
    e.preventDefault();
    // Get the field name
    var quantity = parseInt($('#quantity').val());

    // If is not undefined

    // Increment
    if (quantity > 0) {
        $('#quantity').val(quantity - 1);
    }
    });

});
</script>
