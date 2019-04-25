import {NgModule} from '@angular/core';
import {CommonModule} from '@angular/common';
import {IonicModule} from '@ionic/angular';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {RouterModule} from '@angular/router';

import {HomePage} from './home.page';
import {SearchComponent} from './search/search.component';
import {MessagesComponent} from './messages/messages.component';
import {MyProfileComponent} from './my-profile/my-profile.component';
import {GatheringsComponent} from './gatherings/gatherings.component';
import {ChatRoomComponent} from './messages/chat-room/chat-room.component';


import {FindGatheringComponent} from './gatherings/find-gathering/find-gathering.component';
import {ViewGatheringComponent} from './gatherings/view-gathering/view-gathering.component';
import {HostGatheringComponent} from './gatherings/host-gathering/host-gathering.component';

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
            }, {
                path: 'messages',
                component: MessagesComponent
            }, {
                path: 'chat',
                component: ChatRoomComponent
            }, {
                path: 'my-profile',
                component: MyProfileComponent
            }, {
                path: 'gatherings',
                component: GatheringsComponent
            }, {
                path: 'gatherings/find',
                component: FindGatheringComponent
            }, {
                path: 'gatherings/view/:id',
                component: ViewGatheringComponent
            }, {
                path: 'gatherings/host',
                component: HostGatheringComponent
            }]
        }]),
        ReactiveFormsModule
    ],
    declarations: [
        GatheringsComponent,
        FindGatheringComponent,
        ViewGatheringComponent,
        HostGatheringComponent,
        HomePage,
        MessagesComponent,
        MyProfileComponent,
        SearchComponent,
        SearchComponent,
        ChatRoomComponent
    ]
})
export class HomePageModule {
}
