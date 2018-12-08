import { Component } from '@angular/core';
import { BreakpointObserver, Breakpoints, BreakpointState } from '@angular/cdk/layout';
import {Observable, Subscription} from 'rxjs';
import { ObservableMedia, MediaChange } from '@angular/flex-layout';
import { map } from 'rxjs/operators';
import {MenuItems} from '../../../shared/menu-items/menu-items';
import {Router} from '@angular/router';

@Component({
  selector: 'nav-menu',
  templateUrl: './nav-menu.component.html',
  styleUrls: ['./nav-menu.component.scss']
})
export class NavMenuComponent {
  opened = true;
  over = 'side';
  panelOpenState: boolean;
  watcher: Subscription;
  isHandset$: Observable<boolean> = this.breakpointObserver.observe(Breakpoints.Handset)
    .pipe(
      map(result => result.matches)
    );

constructor(media: ObservableMedia, private breakpointObserver: BreakpointObserver,  public menuItems: MenuItems, private router: Router) {
    this.watcher = media.subscribe((change: MediaChange) => {
      if (change.mqAlias === 'sm' || change.mqAlias === 'xs') {
        this.opened = false;
        this.over = 'over';
      } else {
        this.opened = true;
        this.over = 'side';
      }
    });
  }
  logOut() {
    this.router.navigate(['/login']);
  }

}
