db.getCollection('kirby').aggregate(
    [
        { $match: { template: 'film' } },
        {
            $lookup: {
                from: 'kirby',
                localField: 'actors{}',
                foreignField: '_id',
                as: 'actor_details'
            }
        },
        {
            $project: {
                _id: 1,
                title: 1,
                'actor_details.title': 1
            }
        }
    ],
    { maxTimeMS: 60000, allowDiskUse: true }
);
