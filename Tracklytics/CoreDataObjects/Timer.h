//
//  Timer.h
//  SportsTimer
//
//  Created by Stef Van Gils on 14/11/15.
//  Copyright © 2015 KU Leuven. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "Core.h"

NS_ASSUME_NONNULL_BEGIN

@interface Timer : Core

// Insert code here to declare functionality of your managed object subclass

/**
 * This method has to be called when the event is over and the timer has to be stopped.
 * If it doesn't get called, the timer doesn't get synced to the server.
 */
-(void) stop;

@end

NS_ASSUME_NONNULL_END

#import "Timer+CoreDataProperties.h"
