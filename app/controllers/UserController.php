<?php


class UserController extends ApplicationController
{

    public function new()
    {
        $this->render("new", "Créer un compte", "La Nuit des temps: librairie engagée de proximitée vous propose des livres d'occasion en parfait état");
    }

    public function create()
    {
        if (isset($_POST['user_email'], $_POST['user_password'], $_POST["user_password_confirmation"])) {
            $user = new User($_POST['user_email'], $_POST['user_password']);
            $sign_up_attempt =  $user->signUp($_POST["user_password_confirmation"]);
            if ($sign_up_attempt["type"] == "success") {
                $flash = new Flash($sign_up_attempt["message"], "success");
                $controller = "home";
                $method = "index";
            } else {
                $flash = new Flash($sign_up_attempt["message"], "danger");
                $controller = "user";
                $method = "new";
            }

            if (isset($_POST['checkout']) && $_POST['checkout'] == true) {
                $_SESSION['current_user'] = User::where("email", $_POST['user_email'], "created_at")[0];
                $user = User::getCurrentUser();
                $user->loadSavedBasket();
            }

            if (isset($_POST['remote'])) {
                echo json_encode($sign_up_attempt);
                die();
            } else {
                $flash->storeInSession();
                header("Location:" . REDIRECT_BASE_URL . "controller=$controller&method=$method");
            }
        } elseif (isset($_POST["user_password_check"], $_POST["user_password_confirmation"], $_POST['remote'])) {
            echo json_encode(array("message" => Validator::validatePassword($_POST["user_password_check"], $_POST["user_password_confirmation"]), "type" => "danger"));
        }
    }

    public function destroy()
    {
        if (isset($_SESSION['current_user'], $_POST['user_id'])) {
            if (User::getCurrentUser()->getId() == intval($_POST['user_id'])) {
                $user_destroy = User::destroy($_POST['user_id']);

                if (isset($_POST['remote'])) {
                }
            }
        }
    }

    public function edit()
    {
        if (isset($_SESSION['current_user'])) {
            $orders = User::getCurrentUser()->getInvoices();
            $order_chunks = array_chunk($orders, 2);
            $this->render("edit", "Metttre à jour mon profil", "Compte utilisateur, mise à jour", array("order_chunks" => $order_chunks));
        } else {
            renderError(403);
        }
    }


    public function update()
    {
        if (isset($_SESSION['current_user'])) {

            if (isset($_POST['user_id'])) {
                $user = User::find(intval($_POST['user_id']));

                if (!empty($user)) {
                    $user = $user[0];
                    if (isset($_POST['user_email'])) {
                        $user->updateDatas(null, null, null, $_POST['user_email'], null);
                    } elseif (isset($_POST['user_firstname'])) {
                        $user->updateDatas($_POST['user_firstname'], null, null, null,null);
                    } elseif (isset($_POST['user_lastname'])) {
                        $user->updateDatas(null, $_POST['user_lastname'], null, null,null);
                    } elseif (isset($_POST['user_date_of_birth'])) {
                        $user->updateDatas(null, null, $_POST['user_date_of_birth'], null,null);
                    } elseif (isset($_POST['user_admin'])) {
                        $user->updateDatas(null, null, null, null, $_POST['user_admin'],null);
                    }
                    if (isset($_POST['remote'])) {
                        $user = User::find($user->getId())[0];
                        echo User::resultToJson($user);
                    } else {
                        $path = REDIRECT_BASE_URL . "controller=admin&method=index";
                        header("Location:" . $path);
                    }
                } else {
                    renderError(404);
                }
            }
        } else {
            renderError(403);
        }
    }
}
