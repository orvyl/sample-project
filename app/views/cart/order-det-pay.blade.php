<div class="payment-3-left-holder fl">
	<div class="payment-3-left">
		<div class="p-3-top-left">
			<div class="payment-3-pic-holder payment-img fl"><img src="{{ URL::to('/') }}/images/home/carousel/carousel2.jpg" width="153" height="83" alt="" title=""/></div>
			<div class="p-3-racing payment-title fl">
				@foreach($cart as $prod)
				<p>{{ $prod->qty }} x ${{ $prod->price }} {{ $prod->name }}</p>
				@endforeach
			</div>
			<div class="clr"></div>
		</div>
		<div class="p-3-left-line"></div>
		<div class="p-3-mid-left">
			<div class="p-3-mid-inner-left fl">
				<ul class="p-3-inner-left fl">
					<li>Total =</li>
					<li>Store Credit =</li>
				</ul>
				<ul class="p-3-inner-right fl">
					<li>$ {{ Cart::total() }}</li>
					<li>($ {{ $store_credit }})</li>
				</ul>
				<div class="clr"></div>
			</div>
			<div class="clr"></div>
		</div>
		<div class="p-3-left-line"></div>
		<div class="p-3-bottm-left">
			<p>Order Total = <span>$ {{ $subtotal }}</span></p>
		</div>
	</div>
</div>