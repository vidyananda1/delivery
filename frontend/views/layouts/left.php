<aside class="main-sidebar" style="box-shadow: 0px 0px 20px grey; ">

    <section class="sidebar">

      <div class="user-panel">
          <div class="text-center">
            <img src="images/user.png" height=50 class="img-circle" alt="User Image">
          </div>
            <div class="text-center">
              <h5>Hello ! <?= strtoupper(Yii::$app->user->identity->username)?></h5>
            </div>
          <hr style="border:solid 1px #c2bbba">
          </div>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                  
					            ['label' => 'Dashboard','icon' => 'dashboard', 'url' => ['/site/index']],

                      ['label' => 'Customers','icon' => 'users', 'url' => ['/customer']],

                      ['label' => 'Active Delivery','icon' => 'bell', 'url' => ['/order-detail/activeorder']],

                      //['label' => 'Delivery Items','icon' => 'list', 'url' => ['/order-item/index']],

                      [
                        'label' => 'Delivery Info',
                        'icon' => 'truck',
                        'items' => [
                                      ['label' => 'Pending','url' => ['order-detail/deliverydet']],
                                       
                                      ['label' => 'Delivered', 'url' => ['order-detail/delivery']],

                                      ['label' => 'Cancelled', 'url' => ['order-detail/cancel']],
                                       
                                    
                          ],
                           // 'visible' => !Yii::$app->user->isGuest && Yii::$app->user->can('admin'),
                      ],

                      ['label' => "Rider's Task",'icon' => 'list-alt', 'url' => ['/order-assign/index']],

                      ['label' => 'Pay-Out','icon' => 'dollar', 'url' => ['/order-detail/payout']],

                      ['label' => 'Seller Details','icon' => 'users','url' => ['/seller']],
                      
                      ['label' => 'Expenses','icon' => 'money', 'url' => ['/expense']],
                      ['label' => 'Generate Reports','icon' => 'file', 'url' => ['/report']],
                      
                      
                     

                       [
        								'label' => 'Master-Settings',
        								'icon' => 'wrench',
        								'items' => [
                                      ['label' => 'User-Management','url' => ['/employee']],
          									           
                                      ['label' => 'Product-category', 'url' => ['/category']],

                                      ['label' => 'Carousel Image', 'url' => ['/slider-image']],
                                       
          					                
          								],
          								 // 'visible' => !Yii::$app->user->isGuest && Yii::$app->user->can('admin'),
          						],
                        // 'visible' => !Yii::$app->user->isGuest && Yii::$app->user->can('admin'),
					
                ], // item
            ]
        ) ?>

    </section>

</aside>
<style>
    
</style>