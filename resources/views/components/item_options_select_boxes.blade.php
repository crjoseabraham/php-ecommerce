<div class="select-boxes__wrapper">
    <!-- Size selctor -->
    <ul class="select--default">
        <li>
            <div class="option selected">
                {{ $sizes[0] }}
            </div>
            <p class="select--title">Size</p>
            <span class="arrow"></span>
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