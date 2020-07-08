<!-- Size selctor -->
<div class="select-box__wrapper">
    <ul class="select--default" id="selectSize">
        <li>
            <div class="option selected">
                {{ $sizes[0] }}
            </div>
            <span class="arrow">
                <i class="fas fa-angle-down"></i>
            </span>
            <p class="select--title">Size</p>
        </li>
    </ul>

    <ul class="select--options">
        @foreach ($sizes as $size)
        <li>
            <div class="option">
                {{ $size }}
            </div>
        </li>
        @endforeach
    </ul>
</div>

<!-- Quantity -->
<div class="select-box__wrapper">
    <ul class="select--default"  id="selectQuantity">
        <li>
            <div class="option selected">
                1
            </div>
            <span class="arrow">
                <i class="fas fa-angle-down"></i>
            </span>
            <p class="select--title">Quantity</p>
        </li>
    </ul>

    <ul class="select--options">
        @for ($i = 1; $i <= 10; $i++)
        <li>
            <div class="option">
                {{ $i }}
            </div>
        </li>
        @endfor
    </ul>
</div>