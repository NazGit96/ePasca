import { Routes } from '@angular/router';
import { AppRouteGuard } from '../guards/app-route-guard';

export const content: Routes = [
	{
		path: 'app',
		canActivate: [AppRouteGuard],
    canActivateChild: [AppRouteGuard],
		children: [
			{
				path: '',
				children: [{ path: '', redirectTo: '/app/muka-halaman', pathMatch: 'full' }]
			},
			{
				path: 'muka-halaman',
				loadChildren: () =>
					import('../../main/muka-halaman/muka-halaman.module').then(m => m.MukaHalamanModule),
				data: { preload: true }
			},
			{
				path: 'maklumat/akaun',
				loadChildren: () =>
					import('../../main/maklumat-akaun/maklumat-akaun.module').then(m => m.MaklumatAkaunModule),
				data: { preload: true }
			},
			{
				path: 'mangsa',
				loadChildren: () =>
					import('../../main/pengurusan-mangsa/pengurusan-mangsa.module').then(
						m => m.PengurusanMangsaModule
					),
				data: { preload: true }
			},
			{
				path: 'bencana',
				loadChildren: () =>
					import('../../main/pengurusan-bencana/pengurusan-bencana.module').then(
						m => m.PengurusanBencanaModule
					),
				data: { preload: true }
			},
			{
				path: 'pengguna',
				loadChildren: () =>
					import('../../main/pengurusan-pengguna/pengurusan-pengguna.module').then(
						m => m.PengurusanPenggunaModule
					),
				data: { preload: true }
			},
			{
				path: 'tabung',
				loadChildren: () =>
					import('../../main/pengurusan-tabung/pengurusan-tabung.module').then(
						m => m.PengurusanTabungModule
					),
				data: { preload: true }
			},
			{
				path: 'laporan',
				loadChildren: () =>
					import('../../main/laporan/laporan.module').then(
						m => m.LaporanModule
					),
				data: { preload: true }
			},
			{
				path: 'tetapan',
				loadChildren: () => import('../../main/tetapan/tetapan.module').then(m => m.TetapanModule),
				data: { preload: true }
			},
			{
				path: '**',
				redirectTo: 'notifications'
			}
		]
	}
];