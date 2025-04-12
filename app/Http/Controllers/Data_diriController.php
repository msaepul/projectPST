<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\biodata;
use App\Models\user;
use Illuminate\Support\Facades\Auth;

class Data_diriController extends Controller
{
    public function biodata(Request $request)
    {
        $users = Auth::user()::all(); // Ambil semua data user

        return view('data_diri.biodata', compact('users'));
        

    }
    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'pekerjaan' => 'required|string',
            'tentang' => 'required|string',
        ]);

        // Simpan data ke database
        biodata::create($validatedData);

        // Redirect kembali dengan pesan sukses
        return redirect()->route('data_diri.biodata')->with('success', 'Biodata Telah di update');
    }

    public function upload_avatar()
{
	$this->load->model('profile_model');
	$data['current_user'] = $this->auth_model->current_user();

	if ($this->input->method() === 'post') {
		// the user id contain dot, so we must remove it
		$file_name = str_replace('.','',$data['current_user']->id);
		$config['upload_path']          = FCPATH.'/upload/avatar/';
		$config['allowed_types']        = 'gif|jpg|jpeg|png';
		$config['file_name']            = $file_name;
		$config['overwrite']            = true;
		$config['max_size']             = 1024; // 1MB
		$config['max_width']            = 1080;
		$config['max_height']           = 1080;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('avatar')) {
			$data['error'] = $this->upload->display_errors();
		} else {
			$uploaded_data = $this->upload->data();

			$new_data = [
				'id' => $data['current_user']->id,
				'avatar' => $uploaded_data['file_name'],
			];
	
			if ($this->profile_model->update($new_data)) {
				$this->session->set_flashdata('message', 'Avatar updated!');
				redirect(site_url('admin/setting'));
			}
		}
	}

	$this->load->view('admin/setting_upload_avatar.php', $data);
}





    
}
