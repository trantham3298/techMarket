<?php $this->title = 'Khách hàng' ?>
<div class="col-12 col-lg-10 content-detail">
    <section class="product-content section-main">
        <div class="all-order">
            <h2 class="section-title">Khách hàng / <span>Toàn bộ khách hàng</span></h2>
            <div class="product-total-title">
                <div>
                    <span><strong>Tổng </strong>(<?= $amountCustomer ?>) </span>
                </div>
                <!-- <form>
                    <input type="text" placeholder="Tìm...">
                    <input type="submit" value="Tìm tên">
                </form> -->
            </div>
            <p class="text-danger customer-alert"></p>
            <?php if (\app\core\Application::$app->session->getFlash('success')) :  ?>
                <p class="alert alert-success w-25 flash-success" role="alert"><?php echo \app\core\Application::$app->session->getFlash('success') ?></p>
            <?php endif; ?>
            <div class="table-responsive" style="background-color: #fff;">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <!-- <th scope="col">
                                <input class="input-checkbox-primary" type="checkbox">
                            </th> -->
                            <th scope="col">ID</th>
                            <th scope="col">Tên khách hàng</th>
                            <th scope="col">Email</th>
                            <th scope="col">Giới tính</th>
                            <th scope="col">Số điện thoại</th>
                            <th scope="col">Địa chỉ</th>
                            <th scope="col">Ngày tạo</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customers as $customer) : ?>
                            <tr>
                                <!-- <th style="vertical-align: middle;" scope="row">
                                    <input class="input-checkbox-primary" type="checkbox">
                                </th> -->
                                <td>
                                    <span><span>#<?= $customer->id ?></span></span>
                                </td>
                                <td class="product-total-name">
                                    <span class="product-name"><span><?= $customer->full_name ?></span></span>
                                </td>
                                <td>
                                    <strong class="color-featured"><?= $customer->email ?></strong>
                                </td>
                                <td>
                                    <p><?= $customer->gender['html'] ?></p>
                                </td>
                                <td>
                                    <p><?= $customer->phone ?></p>
                                </td>
                                <td style="width: 400px;">
                                    <span><?= $customer->address ?></span>
                                </td>
                                <td style="color: #414141;">
                                    <span><?= date('d-m-Y', strtotime($customer->created_at)) ?></span>
                                </td>
                                <td>
                                    <button title="Xóa bình luận" class="fas fa-window-close btn-danger button-order-action-primary" data-id="<?= $customer->id ?>" data-toggle="modal" data-target="#delete-customer"></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="10">
                                <div class="page-list" class="text-align-end">
                                    <?php $numPages = ceil($amountCustomer / 7);
                                    for ($i = 1; $i <= $numPages; $i++) : if ($i == $currentPage) : ?>
                                            <a class="currentpage" href="/admin/customer?page=<?= $i ?>"><?= $i ?></a>
                                        <?php else : ?>
                                            <a href="/admin/customer?page=<?= $i ?>"><?= $i ?></a>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="delete-customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Xác Nhận Xóa Khách Hàng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Bạn sẽ xóa khách hàng này này?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="submit-delete-customer">Xác Nhận</button>
            </div>
        </div>
    </div>
</div>