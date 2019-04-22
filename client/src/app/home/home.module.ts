import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {IonicModule} from '@ionic/angular';
import {FormsModule} from '@angular/forms';
import {RouterModule} from '@angular/router';

import {HomePage} from './home.page';
import {SearchComponent} from './search/search.component';
import {MessagesComponent} from './messages/messages.component';
import {MyProfileComponent} from './my-profile/my-profile.component';
import {GatheringsComponent} from './gatherings/gatherings.component';
import {ChatRoomComponent} from './messages/chat-room/chat-room.component';

@NgModule({
    imports: [
        CommonModule,
        FormsModule,
        IonicModule,
        RouterModule.forChild([{
            path: '',
            component: HomePage,
            children: [{
                path: 'search',
                component: SearchComponent
            },
            {
                path: 'messages',
                component: MessagesComponent
            },
            {
                path: 'chat',
                component: ChatRoomComponent
            },
            {
                path: 'my-profile',
                component: MyProfileComponent
            }, {
                path: 'gatherings',
                component: GatheringsComponent
            }]
        }])
    ],
    declarations: [
        GatheringsComponent,
        HomePage,
        MessagesComponent,
        MyProfileComponent,
        SearchComponent,
        ChatRoomComponent
    ]
})
export class HomePageModule {
}
