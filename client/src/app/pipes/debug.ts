import {Pipe, PipeTransform} from '@angular/core';


@Pipe({
    name: 'debug'
})
export class DebugPipe implements PipeTransform {
    public transform(value: any): any {
        console.log(value);
        return value;
    }
}
