import { Avatar, AvatarProps } from '@chakra-ui/core'
import md5 from 'blueimp-md5'
import React from 'react'

export interface GravatarProps extends Omit<AvatarProps, 'src'> {
  email: string
  imgSize?: number
  fallback?:
    | '404'
    | 'mm'
    | 'identicon'
    | 'monsterid'
    | 'wavatar'
    | 'retro'
    | 'robohash'
    | 'blank'
  rating?: 'g' | 'pg' | 'r' | 'x'
}

const GRAVATAR_URI = 'https://www.gravatar.com/avatar/'

const queryString = (params: Record<string, unknown>) =>
  '?' +
  Object.keys(params)
    .map((key) => key + '=' + params[key])
    .join('&')

const Gravatar: React.FC<GravatarProps> = ({
  email,
  imgSize = 120,
  rating = 'g',
  fallback = 'retro',
  ...rest
}) => {
  const uri = `${GRAVATAR_URI}${md5(email)}${queryString({
    size: imgSize,
    d: fallback,
    rating,
  })}`
  return (
    <Avatar
      src={uri}
      cursor="pointer"
      rounded="full"
      bg="transparent"
      {...rest}
    />
  )
}

export default Gravatar
