<?php

$config = array(
                  'login' => array(
                                    array(
                                            'field' => 'email',
                                            'label' => '账号(邮箱)',
                                            'rules' => 'trim|required|valid_email'
                                         ),
                                    array(
                                            'field' => 'password',
                                            'label' => '密码',
                                            'rules' => 'required'
                                         )
                                    )
               );