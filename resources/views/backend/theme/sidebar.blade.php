  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <!-- <a href="../../index3.html" class="brand-link">
      <img src="{{asset('img/logo.png')}}"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">nestoronline.in</span>
    </a> -->

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="{{asset(\Auth::user()->profile_image)}}" class="img-circle elevation-2" alt="User Image">
              </div>
              <div class="info">
                  <a href="#" class="d-block">{{\Auth::user()->mobile}}</a>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  @if(\Auth::user()->role=='Doctor')
                  <li class="nav-item">
                      <a href="{{route('doctordashboard')}}" class="nav-link">
                          <i class="nav-icon fas fa-th"></i>
                          <p>
                              Dashboard
                          </p>
                      </a>
                  </li>
                  <!-- <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Doctor
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{route('backend.doctors.prescribed_order')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Prescribed Order</p>
                              </a>
                          </li>
                      </ul>
                  </li> -->

                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Doctor Appointment
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{route('backend.doctor_appointments.index')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>List</p>
                              </a>
                          </li>
                      </ul>
                  </li>


                  <li class="nav-item has-treeview">
                      <a href="{{route('auth.logout')}}" class="nav-link">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>Logout</p>
                      </a>
                  </li>
                  @endif
                  @if(\Auth::user()->role=='Admin')
                  <li class="nav-item">
                      <a href="{{route('admindashboard')}}" class="nav-link">
                          <i class="nav-icon fas fa-th"></i>
                          <p>
                              Dashboard
                          </p>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a href="{{route('backend.orders.payment_report')}}" class="nav-link">
                          <i class="nav-icon fas fa-th"></i>
                          <p>
                              Payment Report
                          </p>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a href="{{route('backend.user_login_logs.registered_user_list')}}" class="nav-link">
                          <i class="nav-icon fas fa-th"></i>
                          <p>
                              Registered User
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{route('backend.user_login_logs.testing_user_list')}}" class="nav-link">
                          <i class="nav-icon fas fa-th"></i>
                          <p>
                              Testing User
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{route('backend.user_login_logs.index')}}" class="nav-link">
                          <i class="nav-icon fas fa-th"></i>
                          <p>
                              User Login Logs
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{route('backend.contacts.index')}}" class="nav-link">
                          <i class="nav-icon fas fa-th"></i>
                          <p>
                              Contact Us List
                          </p>
                      </a>
                  </li>
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Orders
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">

                          <li class="nav-item">
                              <a href="{{route('backend.order_settings.index')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Order Setting</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('backend.orders.chemist_list_more_than_one_order')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Chemist List With More Than One Order</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('backend.orders.order_report')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Order Report</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('backend.orders.order_tracking_export')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Order Tarcking Report Export</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('backend.orders.order_settelement_report')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Update UTR No. By Date</p>
                              </a>
                          </li>

                          <li class="nav-item">
                              <a href="{{route('backend.orders.payment_export_page')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Payment Export</p>
                              </a>
                          </li>

                      </ul>
                  </li>

                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Chemist
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{route('backend.chemists.create')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Add New</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('backend.chemists.index')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>View List</p>
                              </a>
                          </li>


                          <li class="nav-item">
                              <a href="{{route('backend.chemists.chemist_list_without_Party_Code')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Chemist List Without Party Code</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="#" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Chemist File Delete In Bulk</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('backend.chemists.chemist_list_with_add_to_cart')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Chemist List With Add To Cart Data</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('backend.chemists.chemist_list_dublicate_entry')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Chemist List With Dublicate Entry</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Customer
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{route('backend.chemists.create')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Add New</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('backend.chemists.index')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>View List</p>
                              </a>
                          </li>


                         
                         
                          <li class="nav-item">
                              <a href="{{route('backend.chemists.customer_list_with_add_to_cart')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Customer List With Add To Cart Data</p>
                              </a>
                          </li>
                         
                      </ul>
                  </li>


                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Payment Gatway
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{route('backend.payment_gateways.create')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Add New</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('backend.payment_gateways.index')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>View List</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Mentainence Department
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{route('backend.orders.orders_with_empty_order_code')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Orders With Empty Order Code</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('backend.orders.pending_orders_for_payment')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Orders For Pending For Payment</p>
                              </a>
                          </li>
                      </ul>
                  </li>

                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Doctor Specialization
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{route('backend.doctor_specializations.create')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Add New</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('backend.doctor_specializations.index')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>View List</p>
                              </a>
                          </li>
                      </ul>
                  </li>



                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Slider
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{route('backend.sliders.create')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Add New</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('backend.sliders.index')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>View List</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('backend.sliders.Add_App_Slider')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Add App Slider</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('backend.sliders.App_Slider_List')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>App Slider List</p>
                              </a>
                          </li>
                      </ul>
                  </li>

                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Group
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{route('backend.groups.create')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Add New</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('backend.groups.index')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>View List</p>
                              </a>
                          </li>
                      </ul>
                  </li>

                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Group Category
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{route('backend.groupcategories.create')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Add New</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('backend.groupcategories.index')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>View List</p>
                              </a>
                          </li>
                      </ul>
                  </li>

                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Product
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{route('backend.products.create')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Add New</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('backend.products.index')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>View List</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('backend.products.list_with_price')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>View List With Price</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('backend.products.image')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Product Image List</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('backend.products.export')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Product Export</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('backend.brought_also_products.index')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Product Brought Also Link</p>
                              </a>
                          </li>
                          

                      </ul>
                  </li>

                  <li class="nav-item">
                      <a href="{{route('backend.sales_schemes.index')}}" class="nav-link">
                          <i class="nav-icon fas fa-th"></i>
                          <p>
                              Sales Schemes
                          </p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{route('backend.manufactures.index')}}" class="nav-link">
                          <i class="nav-icon fas fa-th"></i>
                          <p>
                              Manufacture
                          </p>
                      </a>
                  </li>

                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Offer
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{route('backend.sales_schemes.index')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>View List</p>
                              </a>
                          </li>
                      </ul>
                  </li>

                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Description
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{route('backend.descriptions.index')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>View List</p>
                              </a>
                          </li>
                      </ul>
                  </li>

                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Description Type
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{route('backend.description_types.create')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Add New</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('backend.description_types.index')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>View List</p>
                              </a>
                          </li>
                      </ul>
                  </li>

                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Package
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{route('backend.packages.create')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Add New</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('backend.packages.index')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>View List</p>
                              </a>
                          </li>
                      </ul>
                  </li>

                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Chat Bot
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{route('backend.chats.chat_query_list')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Chat Query</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('backend.chat_questions.index')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Chat Question</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('backend.chatquestion_options.index')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Chat Question Option</p>
                              </a>
                          </li>
                      </ul>
                  </li>

                  <li class="nav-item has-treeview">
                      <a href="{{route('backend.upload_prescriptions.index')}}" class="nav-link">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Upload Precription

                          </p>
                      </a>
                  </li>

                  <li class="nav-item has-treeview">
                      <a href="{{route('backend.offices.index')}}" class="nav-link">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>Office</p>
                      </a>
                  </li>

                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Stock
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{route('backend.stocks.index')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Report 1</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('backend.stocks.report2')}}" class="nav-link">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Report 2</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item has-treeview">
                      <a href="{{route('backend.stock_notifications.index')}}" class="nav-link">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>Stock Notication</p>
                      </a>
                  </li>
                  <li class="nav-item has-treeview">
                      <a href="{{route('auth.logout')}}" class="nav-link">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>Logout</p>
                      </a>
                  </li>
                  @endif
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>