<?php

class Pages extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model(['blogers_model', 'articles_model']);
    }

    public function view($page = 'home')
    {
        $this->load->helper('date');

        if(!file_exists(APPPATH . '/views/pages/' . $page . '.php'))
        {
            show_404();
        }

        $data['title'] = ucfirst($page);
        $data['date'] = mdate('%Y-%m-%d %h:%i:%s');

        $this->load->view('templates/header');
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer', $data);
    }
    public function viewOne($b_id = NULL)
    {
        if($this->blogers_model->is_logged_in() == false){
            redirect('pages/view');
        }

        foreach ($this->session->__get('user') as $item => $value)
        {
            if($item == 'id'){
                $b_id = $value;
            } elseif ($item == 'firstname'){
                $data['firstname'] = $value;
            } elseif ($item == 'secondname'){
                $data['secondname'] = $value;
            } elseif ($item == 'login'){
                $data['login'] = $value;
            } elseif ($item == 'age'){
                $data['age'] = $value;
            } elseif ($item == 'country'){
                $data['country'] = $value;
            } elseif ($item == 'city'){
                $data['city'] = $value;
            }
        }
        $data['articles'] = $this->articles_model->get_articles($b_id);

        //var_dump($data['articles'] ); die;

        $this->load->view('templates/header');
        $this->load->view('pages/personal', $data);
        $this->load->view('templates/footer');
    }
}