<?php

namespace App\Http\Controllers;

use App\Jobs\ListenForPayments;
use App\Repository\ProductRepository;
use App\Service\Api\Api;
use App\Service\Payment\Bitcoin\BitcoinService;
use App\Service\Payment\Coinbase\CoinbaseTransactionSearcher;
use Coinbase\Wallet\Resource\Account;
use Illuminate\Http\Request;

class BitcoinController extends AbstractController
{
	private $products;

	public function __construct(ProductRepository $products)
	{
		$this->products = $products;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function createAddress(Request $request, BitcoinService $service)
	{
		$product = $this->products->getById($request->input('product_id'));
		$email = $request->input('email');

		list($btc_address, $btc, $transaction_id) = $service->createAddress($product, $email);

		return Api::toBitcoinResponse($btc_address, $btc, $transaction_id, $request);
	}

	public function notify(CoinbaseTransactionSearcher $searcher)
	{
		dd(true);
		// $client = $searcher->getClient();
		// // $accounts = $client->getAccounts();

		// $acc = Account::reference('941709f3-1755-5725-9c57-fccdaaee40bb');

		// dd($client->getAccountTransactions($acc));

		// dd($acc);


		// dd($accounts);

		




		// foreach ($accounts as $account)
		// {
		// 	try {
		// 		$account->delete();
		// 	} catch (\Exception $e) {
				
		// 	}
		// }

		// dd($accounts);


		$job = (new ListenForPayments('1FVoLptihF9L7pDDySFkfnkiq7HKmvy7fH'))->delay(5); //60 * 2
		dispatch($job);
	}
}