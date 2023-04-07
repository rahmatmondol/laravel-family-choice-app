<?php

namespace App\Http\Controllers\Admin;

use App\Models\Grade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GradeFormRequest;
use App\Http\Controllers\Admin\BaseController;
use App\Interfaces\WalletRepositoryInterface;

class WalletController extends BaseController
{

  // use GradeTrait, PermissionTrait;

  public function __construct(
    private WalletRepositoryInterface $walletRepository
  ) {

    parent::__construct();
    $this->middleware(['permission:read_wallets'])->only('index');
  } //end of constructor

  public function index(Request $request)
  {
    session(['currentPage' => request('page', 1)]);

    $wallets = $this->walletRepository->getFilteredWallets($request);

    return view($this->mainViewPrefix.'.wallets.index', compact('wallets'));
  } // end of index
}//end of controller
