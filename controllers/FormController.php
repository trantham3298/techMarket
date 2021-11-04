<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\exception\NotFoundException;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;

class FormController extends Controller
{
    public MainController $ctrl;

    public function __construct()
    {
        $this->ctrl = new MainController();
        $this->registerMiddleware(new AuthMiddleware(['profile']));
    }

    public function login(Request $request, Response $response)
    {
        if ($this->ctrl->auth->isLoggedIn()) {
            $response->redirect("/");
        }
        if ($request->isPost()) {
            $user = $this->ctrl->auth;
            $data = $request->getBody();
            if ($user->login($data['username'], $data['password'])) {
                exit(json_encode(true));
            } else {
                exit(json_encode(false));
            }
        }
        return $this->render('login', [], 'auth');
    }

    public function logout(Request $request, Response $response)
    {
        $this->ctrl->auth->logout();
        $response->redirect('/');
    }

    public function register(Request $request, Response $response)
    {
        $this->ctrl->auth->logout();
        if ($request->isPost()) {
            $customer = $request->getBody();

            $valid = true;
            $errors = [];
            if (count($this->ctrl->customerModel->find('username', $customer['username'])) > 0) {
                $valid = false;
                $errors[] = 'Tài khoản đã được đăng kí';
            }

            if (filter_var($customer['email'], FILTER_VALIDATE_EMAIL) == false) {
                $valid = false;
                $errors[] = 'Email không chính xác';
            } else {
                $customer['email'] = strtolower($customer['email']);
                if (count($this->ctrl->customerModel->find('email', $customer['email'])) > 0) {
                    $valid = false;
                    $errors[] = 'Email đã được đăng kí';
                }
            }

            if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{5,15}$/', $customer['password'])) {
                $valid = false;
                $errors[] = 'Mật khẩu ít nhất 5 kí tự gồm chữ và số.';
            }

            if ($valid == true) {
                $customer['password'] = password_hash($customer['password'], PASSWORD_DEFAULT);
                $this->ctrl->customerModel->save($customer);
                $this->ctrl->auth->login($customer['username'], $customer['password']);
                Application::$app->session->setFlash('success', 'Bạn đã đăng kí thành công');
                exit(json_encode(true));
            } else {
                exit(json_encode($errors, JSON_UNESCAPED_UNICODE));
            }
        }
        return $this->render('register', [], 'auth');
    }

    public function changePassword(Request $request, Response $response)
    {
        if ($request->isPost()) {
            $data = $request->getBody();
            $valid = true;
            $error = "";

            if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{5,15}$/', $data['password'])) {
                $valid = false;
                $error = 'Mật khẩu ít nhất 5 kí tự gồm chữ và số.';
            }

            $customer = $this->ctrl->customerModel->find('username', $data['username']);
            if (empty($customer) || !password_verify($data['old_password'], $customer[0]->password)) {
                $error = "Tên tài khoản hoặc mật khẩu không chính xác";
                $valid = false;
            }

            if ($valid == true) {
                $this->ctrl->auth->logout();
                unset($data['old_password']);
                $data['id'] = $customer[0]->id;
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                $this->ctrl->customerModel->save($data);
                // $_SESSION['username'] =  $data['username'];
                // $_SESSION['password'] =  $data['password'];
                Application::$app->session->setFlash('success', 'Bạn đã đổi mật khẩu thành công');
                exit(json_encode(true));
            } else {
                exit(json_encode($error, JSON_UNESCAPED_UNICODE));
            }
        }
        return $this->render('/change-password', [], 'auth');
    }

    public function forgotPassword(Request $request, Response $response)
    {
        $this->ctrl->auth->logout();
        if ($request->isPost()) {
            $alert = '';
            $data = $request->getBody();
            if (isset($data['email'])) {
                $customer = $this->ctrl->customerModel->find('email', $data['email']);
                if (count($customer) > 0) {
                    $email = md5($customer[0]->email);
                    $resetPass = $this->ctrl->resetPasswordModel->find('email', $customer[0]->email);
                    if (empty($resetPass)) {
                        $pass = (md5(openssl_random_pseudo_bytes(20)));
                    } else {
                        $pass = $resetPass[0]->token;
                    }
                    $link = "<a href='/reset-password?key=$email&reset=$pass'>Click To Reset password</a>";
                    $check = $this->ctrl->sendMail("Lấy lại mật khẩu", $link, $customer[0]->email);
                    if ($check) {
                        $alert = 'Đã gửi mã về mail của bạn';
                        if (empty($resetPass)) {
                            $data['token'] = $pass;
                            $data['time'] = date('Y-m-d h:i:s');
                            $this->ctrl->resetPasswordModel->save($data);
                        }
                    } else {
                        $alert = 'Gửi mail thất bại';
                    }
                } else {
                    $alert = 'Email không tồn tại';
                }
            }
            exit(json_encode($alert));
        }
        return $this->render('forgot-password', [], 'auth');
    }

    public function resetPassword(Request $request, Response $response)
    {
        $this->ctrl->auth->logout();
        if ($request->isPost()) {
            $data = $request->getBody();
            $valid = true;
            $errors = '';
            if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{5,15}$/', $data['password'])) {
                $valid = false;
                $errors = 'Mật khẩu ít nhất 5 kí tự gồm chữ và số.';
            }
            if ($valid) {
                $customer = $this->ctrl->customerModel->findById($data['id']);
                $customer->password = password_hash($data['password'], PASSWORD_DEFAULT);
                $this->ctrl->customerModel->save((array)$customer);
                Application::$app->session->setFlash('success', 'Bạn đã đổi mật khẩu thành công');
                exit(json_encode(true));
            } else {
                exit(json_encode($errors, JSON_UNESCAPED_UNICODE));
            }
        }
        if (isset($_GET['key']) && isset($_GET['reset'])) {
            $key = $_GET['key'];
            $pass = $_GET['reset'];
            $resetPass = $this->ctrl->resetPasswordModel->find("md5(email)", $key);
            if (count($resetPass) > 0) {
                if ($resetPass[0]->token != $pass) {
                    $resetPass[0]->num_check++;
                    $this->ctrl->resetPasswordModel->save((array)$resetPass[0]);
                    if ($resetPass[0]->num_check > 3) {
                        $this->ctrl->resetPasswordModel->delete($resetPass[0]->id);
                    }
                    throw new NotFoundException();
                } elseif (round(((time() - strtotime($resetPass[0]->time)) / (60 * 60 * 24))) > 1) {
                    $this->ctrl->resetPasswordModel->delete($resetPass[0]->id);
                    throw new NotFoundException();
                } else {
                    $customer = $this->ctrl->customerModel->find("email", $resetPass[0]->email);
                }
                return $this->render('reset-password', ['customer' => $customer[0]], 'auth');
            } else {
                throw new NotFoundException();
            }
        } else {
            throw new NotFoundException();
        }
    }

    public function checkout(Request $request, Response $response)
    {
        if ($request->isPost()) {
            $order = $request->getBody();
            $orderId = $this->ctrl->orderModel->save($order);

            foreach ($_SESSION['cart'] as $product) {
                $orderDetail['id'] = '';
                $orderDetail['order_id'] = $orderId;
                $orderDetail['product_id'] = $product['product_id'];
                $orderDetail['quantity'] = $product['quantity'];
                if (!empty($product['discount_price'])) {
                    $orderDetail['unit_price'] = $product['discount_price'];
                } else {
                    $orderDetail['unit_price'] = $product['list_price'];
                }
                $this->ctrl->orderDetailModel->save($orderDetail);
            }

            unset($_SESSION['cart']);
            unset($_SESSION['amount']);
            unset($_SESSION['subtotal']);
            unset($_SESSION['total_discount']);
            unset($_SESSION['total_price']);

            Application::$app->session->setFlash('success', 'Bạn đã đặt hàng thành công');
            $response->redirect('/');
        }
        return $this->render('checkout', []);
    }

    public function contact(Request $request, Response $response)
    {
        if ($request->isPost()) {
            $alert = '';
            $data = $request->getBody();
            if (isset($data['email']) || filter_var($data['email'], FILTER_VALIDATE_EMAIL) == true) {
                $subject = "Phản hồi từ khách hàng";
                $body = "Tên khách hàng: $data[full_name]<br> Email: $data[email]<br> Nội dung: $data[body]"; 
                $check = $this->ctrl->sendMail($subject, $body, "thang111220@gmail.com");
                if ($check) {
                    $alert = 'Phản hồi của bạn đã được gửi đi';
                } else {
                    $alert = 'Gửi mail thất bại';
                }
            } else {
                $alert = 'Email không hợp lệ';
            }
            exit(json_encode($alert));
        }
        return $this->render('contact', []);

        // $data = $request->getBody();
        // $this->ctrl->contactModel->save($data);
        // Application::$app->session->setFlash('success', 'Bạn đã gửi phản hồi thành công');

    }

    public function about()
    {
        return $this->render('about', []);
    }

    public function profile(Request $request, Response $response)
    {
        if ($request->isPost()) {
            $customer = $request->getBody();

            $valid = true;
            $errors = [];
            if (filter_var($customer['email'], FILTER_VALIDATE_EMAIL) == false) {
                $valid = false;
                $errors[] = 'Invalid email address';
            } else {
                $customer['email'] = strtolower($customer['email']);
            }
            if ($valid == true) {
                $this->ctrl->customerModel->save($customer);
                Application::$app->session->setFlash('success', 'Bạn đã sửa thông tin thành công');
                $response->redirect('/profile');
            } else {
                return $this->render('profile', [
                    'errors' => $errors,
                ]);
            }
        }
        return $this->render('profile');
    }
}
