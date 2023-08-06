<?php
$cart = $_SESSION['cart'];
$total = 0;
$totalItem = 0;


if (exist_param("remove")) {
  $id = $_GET['id'];
  $size = $_GET['size'];
  // xoa bo item voi id = $id trong session
  $_SESSION['cart'] = array_filter(
    $cart,
    // closure lọc nếu item nào có id != $id hoặc size != $size thì return true 
    function ($item) use ($id, $size) {
      return $item['id'] != $id || $item['size'] != $size;
    }
  );

  echo "<script>window.location.href='homepage?cart';</script>";
  exit;
}

foreach ($cart as $item) {
  $total += $item['price'] * $item['quantity'];
  $totalItem += $item['quantity'];
}

// echo var_dump($cart);

?>

<section class="container mx-auto mt-10">
  <div class="flex shadow-md my-10">
    <div class="w-3/4 bg-white px-10 py-10">
      <div class="flex justify-between border-b pb-8">
        <h1 class="font-semibold text-2xl">Giỏ hàng</h1>
        <h2 class="font-semibold text-2xl">
          <?= $totalItem ?> sản phẩm
        </h2>
      </div>
      <div class="flex mt-10 mb-5">
        <h3 class="font-semibold text-gray-600 text-xs uppercase w-2/5">Chi tiết sản phẩm</h3>
        <h3 class="font-semibold  text-gray-600 text-xs uppercase w-1/5 text-center">Số lượng</h3>
        <h3 class="font-semibold text-gray-600 text-xs uppercase w-1/5 text-center">Đơn giá</h3>
        <h3 class="font-semibold  text-gray-600 text-xs uppercase w-1/5 text-center">Tổng giá</h3>
        <h3 class="font-semibold  text-gray-600 text-xs uppercase w-1/5 text-center">Kích cỡ</h3>
      </div>
      <!-- product -->
      <?php foreach ($cart as $item) { ?>
      <div class="flex items-center hover:bg-gray-100 -mx-8 px-6 py-5">
        <div class="flex w-2/5">
          <div class="w-20">
            <img class="h-24" src="/<?= $item['image'] ?>" alt="">
          </div>
          <div class="flex flex-col justify-between ml-4 flex-grow">
            <span class="font-bold text-sm">
              <?= $item['name'] ?>
            </span>
            <span class="text-red-500 text-xs">
              <?= $item['category'] ?>
            </span>
            <a href="/site/homepage?cart&remove&id=<?= $item['id'] ?>&size=<?= $item['size'] ?>"
              class="font-semibold hover:text-red-500 text-gray-500 text-xs">Gỡ bỏ</a>
          </div>
        </div>
        <div class="flex justify-center w-1/5">

          <span class="mx-2 border text-center w-8">
            <?= $item['quantity'] ?>
          </span>



        </div>
        <span class="text-center w-1/5 font-semibold text-sm">
          <?= number_format($item['price'], 0, ',', '.') ?> VND
        </span>
        <span class="text-center w-1/5 font-semibold text-sm">
          <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>
          VND
        </span>
        <span class="text-center w-1/5 font-semibold text-sm ">
          Size
          <?= substr($item['size'], 5) ?>
        </span>
      </div>
      <?php } ?>

      <!-- product -->



      <a href="/site/product" class="flex font-semibold text-indigo-600 text-sm mt-10">

        <svg class="fill-current mr-2 text-indigo-600 w-4" viewBox="0 0 448 512">
          <path
            d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z" />
        </svg>
        Tiếp tục mua hàng
      </a>
    </div>

    <div id="summary" class="w-1/4 px-8 py-10 border-l-2">
      <h1 class="font-semibold text-2xl border-b pb-8">Đơn hàng</h1>
      <div class="flex justify-between mt-10 mb-5">
        <span class="font-semibold text-sm uppercase">Tổng</span>
        <span class="font-semibold text-sm">
          <?= number_format($total, 0, ',', '.') ?> VND
        </span>
      </div>
      <div class="py-10">
        <label for="promo" class="font-semibold inline-block mb-3 text-sm uppercase">Mã giảm giá</label>
        <input type="text" id="promo" placeholder="Enter your code" class="border p-2 text-sm w-full">
      </div>
      <button class="bg-red-500 hover:bg-red-600 px-5 py-2 text-sm text-white uppercase">Áp dụng</button>
      <div class="border-t mt-8 flex flex-col">
        <div class="flex font-semibold justify-between py-6 text-sm uppercase">
          <span>Tổng tiền</span>
          <span>
            <?php if (number_format($total) > 0) {
              echo number_format($total, 0, ',', '.');
            } else {
              echo 0;
            } ?> VND
          </span>
        </div>
        <?php if ($totalItem > 0) { ?>
        <a href="/site/order/index.php?information"
          class="bg-indigo-500 font-semibold hover:bg-indigo-600 py-3 text-center text-sm text-white uppercase w-full ">Thanh
          toán</a>
        <?php } else { ?>
        <a href="/site/product"
          class="bg-indigo-500 font-semibold hover:bg-indigo-600 py-3 text-center text-sm text-white uppercase w-full ">Mua
          hàng</a>
        <?php } ?>


      </div>
    </div>

  </div>
</section>